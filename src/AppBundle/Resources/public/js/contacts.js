$(function () {
    var selectedCities = [];
    var selectedGoals = [];

    function filterContacts () {

        $('.contact').each(function () {
            var contactGoals = $(this).data('goals') || {};
            var show = false;

            if (selectedGoals.length !== 0) {
                for (var key in selectedGoals) {
                    var selectedGoal = selectedGoals[key];

                    if (contactGoals.hasOwnProperty(selectedGoal)) {
                        if (selectedCities.length === 0) {
                            //user want this goal in all cities
                            show = true;
                        }

                        if (contactGoals[selectedGoal].length === 0) {
                            //contact performs this goal in all cities
                            show = true;
                        }

                        if (selectedCities.intersects(contactGoals[selectedGoal])) {
                            //user selected both goal and city, and they intersect with contact
                            show = true;
                        }
                    }
                }
            } else {
                if (selectedCities.length === 0) {
                    //user did not specify any filters
                    show = true;
                }

                for (var goalKey in contactGoals) {
                    if (contactGoals[goalKey].intersects(selectedCities)) {
                        //contact performs this goal in one of selected cities
                        show = true;
                    }

                    if (contactGoals[goalKey].length === 0) {
                        //contact performs this goal in all cities
                        show = true;
                    }
                }
            }

            if (show) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    }

    $("#goal button").click(function () {
        selectedGoals.toggleValue($(this).data('goal'));
        $(this).toggleClass('active');
        filterContacts();
    });

    $("#city button").click(function () {
        selectedCities.toggleValue($(this).data('city'));
        $(this).toggleClass('active');
        filterContacts();
    });

    if (window.location.search.indexOf('?') !== -1) {
        var queryString = window.location.search.substring(
            window.location.search.indexOf('?') + 1
        ).split('&');
        for (var element in queryString) {
            if (queryString[element].startsWith && queryString[element].startsWith('city=')) {
                $('#city').find('[data-city='+queryString[element].replace('city=', '')+']').click();
            }
        }
    }
});
