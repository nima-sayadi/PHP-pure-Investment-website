$("form.stepy").stepy({
    nextButtonClass : 'btn btn-info',   // Change the next button class.
    prevButtonClass : 'btn btn-danger',   // Change the back button class.
    backLabel       : 'قبلی',   // Change the back button label.
    nextLabel       : 'بعدی',   // Change the next button label.
    transition      : 'fade',      // Use transition between steps ('hide', 'fade' or 'slide').
    back            : undefined,  // Callback before the backward action.
    block           : false,      // Block the next step if the current is invalid.
    description     : false,      // Choose if the descriptions of the titles will be showed.
    duration        : 0,          // Duration of the transition between steps in ms.
    enter           : true,       // Enables the enter key to change to the next step.
    errorImage       : false,      // If an error occurs, a image is showed in the title of the corresponding step.
    finish          : undefined,  // Callback before the finish action.
    finishButton    : true,       // Include the button with class called '.finish' into the last step.
    ignore          : '',         // Choose the fields to be ignored on validation.
    legend          : false,      // Choose if the legends of the steps will be showed.
    next            : undefined , // Callback before the forward action.
    select          : undefined,  // Callback executed when the step is shown.
    titleClick      : true,       // Active the back and next action in the titles.
    titleTarget     : undefined,  // Choose the place where titles will be placed.
    validate        : false        // Active the jQuery Validation for each step.
});