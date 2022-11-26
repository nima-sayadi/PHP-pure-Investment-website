$(".cropper-container>img").cropper({aspectRatio:1});


$(".aspectratio-4-3>img").cropper({aspectRatio: 4/3});


$(".cropper-box>img").cropper({
    crop: function(e) {
        $("#crop-x").val(e.x);
        $("#crop-y").val(e.y);
        $("#crop-width").val(e.width);
        $("#crop-height").val(e.height);
    }
});


var $image = $(".cropper-for-modal>img");
var cropBoxData;
var canvasData;
$("#cropper-modal").on("shown.bs.modal", function() {
    $image.cropper({
        autoCropArea: 0.5,
        built: function() {
            $image.cropper("setCanvasData", canvasData);
            $image.cropper("setCropBoxData", cropBoxData);
        }
    });
}).on("hidden.bs.modal", function() {
    cropBoxData = $image.cropper("getCropBoxData");
    canvasData = $image.cropper("getCanvasData");
    $image.cropper("destroy");
});
