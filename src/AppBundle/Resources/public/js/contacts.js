$(function () {
    var selectedCities = [];
    var selectedGoals = [];
    var Shuffle = window.shuffle;

    var shuffle = new Shuffle(
        document.getElementById('grid'),
        {
            itemSelector: '.contact'
        }
    );

    function filterContacts () {
        shuffle.filter(function (item) {
            var contactGoals = $(item).data('goals') || {};

            if (selectedGoals.length !== 0) {
                for (var key in selectedGoals) {
                    var selectedGoal = selectedGoals[key];

                    if (contactGoals.hasOwnProperty(selectedGoal)) {
                        if (selectedCities.length === 0) {
                            //user want this goal in all cities
                            return true;
                        }

                        if (contactGoals[selectedGoal].length === 0) {
                            //contact performs this goal in all cities
                            return true;
                        }

                        if (selectedCities.intersects(contactGoals[selectedGoal])) {
                            //user selected both goal and city, and they intersect with contact
                            return true;
                        }
                    }
                }
            } else {
                if (selectedCities.length === 0) {
                    //user did not specify any filters
                    return true;
                }

                for (var goalKey in contactGoals) {
                    if (contactGoals[goalKey].intersects(selectedCities)) {
                        //contact performs this goal in one of selected cities
                        return true;
                    }

                    if (contactGoals[goalKey].length === 0) {
                        //contact performs this goal in all cities
                        return true;
                    }
                }
            }

            return false;
        });

        shuffle.sort({randomize: true});
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
});
