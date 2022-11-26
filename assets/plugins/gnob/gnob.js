'use strict';
// Thanks Mozilla! https://developer.mozilla.org/en-US/docs/Web/Events/wheel
// creates a global 'addWheelListener' method
// example: addWheelListener( elem, function( e ) { console.log( e.deltaY ); e.preventDefault(); } );
(function(window, document) {
  var prefix = '',
    _addEventListener, onwheel, support;

  // detect event model
  if (window.addEventListener) {
    _addEventListener = 'addEventListener';
  } else {
    _addEventListener = 'attachEvent';
    prefix = 'on';
  }

  // detect available wheel event
  support = 'onwheel' in document.createElement('div') ? 'wheel' : // Modern browsers support 'wheel'
    document.onmousewheel !== undefined ? 'mousewheel' : // Webkit and IE support at least 'mousewheel'
    'DOMMouseScroll'; // let's assume that remaining browsers are older Firefox

  window.addWheelListener = function(elem, callback, useCapture) {
    _addWheelListener(elem, support, callback, useCapture);

    // handle MozMousePixelScroll in older Firefox
    if (support == 'DOMMouseScroll') {
      _addWheelListener(elem, 'MozMousePixelScroll', callback, useCapture);
    }
  };

  function _addWheelListener(elem, eventName, callback, useCapture) {
    elem[_addEventListener](prefix + eventName, support == 'wheel' ? callback : function(originalEvent) {
      !originalEvent && (originalEvent = window.event);

      // create a normalized event object
      var event = {
        // keep a ref to the original event object
        originalEvent: originalEvent,
        target: originalEvent.target || originalEvent.srcElement,
        type: 'wheel',
        deltaMode: originalEvent.type == 'MozMousePixelScroll' ? 0 : 1,
        deltaX: 0,
        deltaZ: 0,
        preventDefault: function() {
          originalEvent.preventDefault ?
            originalEvent.preventDefault() :
            originalEvent.returnValue = false;
        }
      };

      // calculate deltaY (and deltaX) according to the event
      if (support == 'mousewheel') {
        event.deltaY = -1 / 40 * originalEvent.wheelDelta;
        // Webkit also support wheelDeltaX
        originalEvent.wheelDeltaX && (event.deltaX = -1 / 40 * originalEvent.wheelDeltaX);
      } else {
        event.deltaY = originalEvent.detail;
      }

      // it's time to fire the callback
      return callback(event);

    }, useCapture || false);
  }
})(window, document);

var NATURAL_OFF_POS = 0;
var NATURAL_OFF_DEG = -190;
var NATURAL_MAX_POS = 295;

var Gnob = function(rangeElem) {
  this.settings = this.getSettings(rangeElem);
  this.min      = (this.settings.min || 0);
  this.max      = this.settings.max ? this.settings.max:10;
  this.step     = (this.settings.step || 1);
  this.initial  = (this.settings.initial || 0);
  this.diameter = (this.settings.diameter || 100);
  this.size     = (this.settings.size || 'medium');
  this.position = this.initial;
  this.ticks    = this.getTicks();

  this.createKnob(rangeElem);

  this.setValue(this.initial);
};

Gnob.prototype.getSettings = function(rangeElem) {
  var options = {};

  Array.prototype.slice
    .call(rangeElem.attributes)
    .map(function(attr) {
      if (attr.name.indexOf('gnob') > -1) {
        var name = attr.name.replace(/data-gnob-?/, ''),
          intVal = parseInt(attr.value, 10);
        if (name) {
          options[name] = (intVal || intVal === 0) ? intVal : attr.value;
        }
      }
    });

  return options;
};

Gnob.prototype.setValue = function(value) {
  value = parseInt(value, 10);

  if (value > this.max) {
    value = this.max;
  }
  else if (value < this.min) {
    value = this.min;
  }
  else if (!value && value !== 0) {
    return false;
  }

  var position = NATURAL_OFF_DEG + (value > 0 ? this.ticks[value] : 0);

  this.position        = this.ticks[value];
  this.rangeElem.value = position;
  this.input.value     = value;
  
  this.setRotation(position);

  this.rangeElemOnChange(value);
};

Gnob.prototype.setRotation = function(value) {
  var inner = this.knobElem.children[0];

  inner.style.transform = 'rotate(' + value + 'deg)';
};

Gnob.prototype.rangeElemOnChange = function(value) {
  if (typeof this.rangeElem.onchange !== 'function') {
    console.log('Gnob Error: No onchange event found! Try adding an onchange event listener to the range element!');
  }
  else {
   this.rangeElem.onchange(this.rangeElem.value);
  }
};

Gnob.prototype.createKnob = function(rangeElem) {
  var knob = document.createElement('div');
  var inner = document.createElement('div');
  var indicator = document.createElement('div');
  var popover = document.createElement('div');
  var popoverInput = document.createElement('input');

  rangeElem.setAttribute('min', this.min);
  rangeElem.setAttribute('max', this.max);
  rangeElem.setAttribute('step', this.step);

  this.rangeElem = rangeElem;

  knob.classList.add(this.size);
  knob.classList.add('gnob');
  inner.classList.add('inner');
  indicator.classList.add('indicator');
  popover.classList.add('popover');
  popover.classList.add(this.settings.popover);
  popoverInput.setAttribute('type', 'text');
  popover.appendChild(popoverInput);
  inner.appendChild(indicator);
  knob.appendChild(inner);
  knob.appendChild(popover);

  if (this.settings.indicator) {
    indicator.style.background = this.settings.indicator;
    indicator.style.boxShadow  = '0px 0px 8px ' +   this.settings.indicator;
  }

  this.inner = inner;
  this.knobElem = knob;
  this.popover = popover;
  this.input = popoverInput;

  this.setRotation(NATURAL_OFF_DEG);

  this.bindEvents(knob);

  rangeElem.parentNode.replaceChild(knob, rangeElem);
};

Gnob.prototype.rotate = function(delta) {
  var direction = delta > 0 ? 1 : -1;
  var step      = this.step * direction;
  var rotation  = NATURAL_OFF_DEG + this.position + step;

  this.position += (direction + delta);

  if (this.position <= NATURAL_OFF_POS) {
    this.position = NATURAL_OFF_POS;
  } else if (this.position >= NATURAL_MAX_POS) {
    this.position = NATURAL_MAX_POS;
  }

  this.tick(this.position);

  this.setRotation(rotation);
};

Gnob.prototype.getTicks = function() {
  var out = [];
  var ticks = NATURAL_MAX_POS - NATURAL_OFF_POS;
  var inclusiveMax = this.max + 1;

  var betweenTicks = ticks / inclusiveMax;

  for (var i = 0; i < inclusiveMax; i++) {
    out.push(i * betweenTicks);
  }

  out.pop();

  out.push(NATURAL_MAX_POS);

  return out;
};

Gnob.prototype.tick = function(position) {
  var _this = this;
  var firstTick = _this.ticks[0];
  var lastTick = _this.ticks[_this.ticks.length - 1];
  var lastTickIndex = _this.ticks.indexOf(lastTick);
  var outOfRange = position >= lastTick;
  var isFirstTick = position <= firstTick;

  if (outOfRange) {
    _this.rangeElem.value = lastTickIndex;
    _this.input.value = lastTickIndex;
  } else if (isFirstTick) {
    _this.rangeElem.value = position;
    _this.input.value = position;
  } else {
    this.ticks.forEach(function(tick, i) {
      var inTickRange = position > tick && position < _this.ticks[i + 1];

      if (inTickRange) {
        _this.rangeElem.value = i;
        _this.input.value = i;
      }
    });
  }

  _this.rangeElemOnChange(_this.rangeElem.value);
};

Gnob.prototype.bindEvents = function(knobElem) {
  var _this = this;

  window.addWheelListener(knobElem, function(e) {
    _this.rotate(e.deltaY ? e.deltaY : e.deltaX * -1);
    e.preventDefault();
  }, false);

  _this.input.onchange = function(e) {
    _this.setValue(this.value);
    _this.popover.classList.remove('open');
  };

  _this.input.onblur = function() {
    //_this.popover.classList.remove('open');
  };

  _this.inner.ondblclick = function() {
    _this.popover.classList.add('open');
    _this.input.focus();
  };

  _this.input.onkeydown = function(e) {
    var which = e.keyCode;
    var value = parseInt(_this.input.value, 10);

    if (which === 38) {
      _this.setValue(value + 1);
    }
    else if (which === 40) {
      _this.setValue(value - 1);
    }
    else if(which === 13) {
      _this.setValue(value);
      _this.popover.classList.remove('open');
    }
  };
};
