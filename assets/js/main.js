/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (main.scss in this case)
require('../css/main.scss');

$(document).ready(function() {
  $(".menu__toggle").on("click", function(e) {
    $(this).find("i").toggleClass("fas fa-bars fas fa-times");
    $(".menu__item").fadeToggle();
  });
});
