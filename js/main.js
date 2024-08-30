$(document).ready(function() {

    // Toggles the navigation bar and hamburger icon when the menu icon is clicked
    $('.fa-bars').click(function() {
        $(this).toggleClass('fa-times'); // Toggles the icon from bars to times (X)
        $('.navbar').toggleClass('nav-toggle'); // Toggles the visibility of the navigation menu
    });

    // Adjusts the navigation bar style and resets the menu icon and navbar when the page is loaded or scrolled
    $(window).on('load scroll', function() {
        $('.fa-bars').removeClass('fa-times'); // Removes the times (X) icon class
        $('.navbar').removeClass('nav-toggle'); // Removes the toggle class from navbar to hide it

        // Changes the header background and adds a shadow when the scroll position is greater than 35 pixels
        if ($(window).scrollTop() > 35) {
            $('.header').css({
                'background': '#002e5f',
                'box-shadow': '0 .2rem .5rem rgba(0,0,0,.4)'
            });
        } else {
            // Resets the header style when the scroll position is less than 35 pixels
            $('.header').css({
                'background': 'none',
                'box-shadow': 'none'
            });
        }
    });

    // Counter animation to increment numbers from 0 to their target value
    const counters = document.querySelectorAll('.counter');
    const speed = 500; // Adjust this value to control how slowly the counter increments
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target'); // Gets the target value from data-target attribute
            const count = +counter.innerText; // Gets the current count value
            const inc = target / speed; // Calculates the increment value
            if (count < target) {
                counter.innerText = Math.ceil(count + inc); // Updates the counter with the new value
                setTimeout(updateCount, 100); // Repeats the update after 100 milliseconds
            } else {
                counter.innerText = target; // Sets the counter to the target value when it reaches or exceeds it
            }
        };
        updateCount(); // Starts the counter update
    });

    // Initializes carousels for clients and testimonials using Owl Carousel plugin
    (function($) {
        "use strict";

        $(".clients-carousel").owlCarousel({
            autoplay: true,
            dots: true,
            loop: true,
            responsive: {
                0: { items: 2 },
                768: { items: 4 },
                900: { items: 6 }
            }
        });

        $(".testimonials-carousel").owlCarousel({
            autoplay: true,
            dots: true,
            loop: true,
            responsive: {
                0: { items: 1 },
                576: { items: 2 },
                768: { items: 3 },
                992: { items: 4 }
            }
        });

        // Submits the subscription form using AJAX
        $('#subscribeme').on('submit', function(event) {
            event.preventDefault(); // Prevents the default form submission

            $.ajax({
                url: 'subscribeme.php', // Server-side script to handle subscription
                type: 'POST',
                data: $(this).serialize(), // Serializes the form data
                dataType: 'json', // Expects JSON response from the server
                success: function(response) {
                    // Displays success or error message based on the response
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '#footer'; // Redirects to footer after confirmation
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handles AJAX request failure
                    console.error("AJAX Request Failed:", status, error);
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to subscribe. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

        // Submits the contact form using AJAX
        $('#contactForm').on('submit', function(event) {
            event.preventDefault(); // Prevents the default form submission

            $.ajax({
                url: 'contactme.php', // Server-side script to handle contact form
                type: 'POST',
                data: $(this).serialize(), // Serializes the form data
                dataType: 'json', // Expects JSON response from the server
                success: function(response) {
                    // Displays success or error message based on the response
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.html#contact'; // Redirects to contact section after confirmation
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handles AJAX request failure
                    console.error("AJAX Request Failed:", status, error);
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to send message. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

    })(jQuery);

    // Handles the back-to-top button visibility and functionality
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow'); // Shows the button when scrolled down
        } else {
            $('.back-to-top').fadeOut('slow'); // Hides the button when near the top
        }
    });

    // Scrolls to the top when the back-to-top button is clicked
    $('.back-to-top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo'); // Smooth scrolling to the top
        return false; // Prevents default anchor behavior
    });

    // Handles accordion functionality to show and hide content sections
    $('.accordion-header').click(function() {
        $('.accordion .accordion-body').slideUp(500); // Collapses all accordion bodies
        $(this).next('.accordion-body').slideDown(500); // Expands the clicked accordion body
        $('.accordion .accordion-header span').text('+'); // Resets all headers to show the '+' sign
        $(this).children('span').text('-'); // Changes the clicked header to show the '-' sign
    });

    // Sets the current year in an element with the ID 'currentYear'
    document.getElementById('currentYear').textContent = new Date().getFullYear();

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault(); // Prevents default anchor behavior

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth' // Smoothly scrolls to the target section
            });
        });
    });
});
