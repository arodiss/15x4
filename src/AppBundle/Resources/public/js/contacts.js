$(function () {
    var selectedGoals = [];
    var selectedCities = [];
    if (window.location.href.search('#') != -1) {
        var selectedCities = JSON.parse(window.location.href.slice(window.location.href.search("#")+1));
    }
    $("#city button").each(function () {
        if (selectedCities.includes($(this).data('city'))) {
            $(this).toggleClass('active');
        }
    });

    filterContacts();
    filterGlobalContacts ();
    filterCities ();

    function filterSingleContact(contactGoals){

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
        return show;
    }

    function filterContacts () {
        $("#contacts").hide();

        $('#contacts .contact').each(function () {
            var contactGoals = $(this).data('goals') || {};
            var show = filterSingleContact(contactGoals);

            if (show) {
                $(this).fadeIn();
                $("#contacts").show();
            } else {
                $(this).fadeOut();
            }
        });
    }

    function filterGlobalContacts () {

        $("#global_contacts").hide();

        $('#global_contacts .contact').each(function () {
            var contactGoals = $(this).data('goals') || {};
            var show = filterSingleContact(contactGoals);

            if (show) {
                $(this).fadeIn();
                $("#global_contacts").show();
            } else {
                $(this).fadeOut();
            }
        });
    }

    function filterCities () {
        $("#city_resources").hide();

        $('.social').each(function () {
            var cityId = $(this).data('city_id');
            var show = false;

            if (selectedCities.length === 0) {
                //user did not specify any filters
                show = true;
            }

            if (selectedCities.includes(cityId)){
                show = true;
            }

            if (show) {
                $(this).fadeIn();
                $("#city_resources").show();
            } else {
                $(this).fadeOut();
            }
        });
    }

    $("#goal button").click(function () {
        selectedGoals.toggleValue($(this).data('goal'));
        $(this).toggleClass('active');
        filterContacts();
        filterGlobalContacts ();
    });

    $("#city button").click(function () {
        selectedCities.toggleValue($(this).data('city'));
        $(this).toggleClass('active');
        window.location.href = window.location.pathname + '#' + JSON.stringify(selectedCities);
        filterContacts();
        filterGlobalContacts ();
        filterCities();
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
