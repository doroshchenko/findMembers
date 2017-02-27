/**
 * Created by dima on 2/22/17.
 */

var EventForm = {

    config: {
        selectors: {
            country : '#event_country',
            region  : '#event_region',
            city    : '#event_city'
        }
    },

    init: function() {
        var regions = $(this.config.selectors.region + ' option');
            cities = $(this.config.selectors.city + ' option'),
            countrySelected = $(this.config.selectors.country).val(),
            regionSelected = $(this.config.selectors.region).val();

        var that = this;
        if (countrySelected) {
            let promise = new Promise((resolve,reject) => {
                that.getRegionList(countrySelected, Routing.generate('ajax_regions'), resolve);  });
            promise.then( function() {
                if (regionSelected) {
                    var regions = $(this.config.selectors.region + 'option');
                    $.each(regions, function(i, val) {
                        if ($(val).val() == regionSelected) {
                            $(val).attr('selected','selected');
                        }
                    });
                    getCityList(regionSelected, Routing.generate('ajax_cities'));
                } else {
                    cities.hide();
                }
            }, function(error) {
                alert("Rejected: " + error);
            });
        } else {
            regions.hide();
            cities.hide();
        }
    },
    getRegionList: function(countryId, url, resolve = null)
    {
        var that = this;
        $.ajax({
            url: url,
            data: {countryId: countryId},
            method: 'post',
            success: function(res) {
                var options = '<option>Регион</option>';
                for (var i in res.regions) {
                    options += '<option value ="' + res.regions[i].id +'">'+ res.regions[i].name +'</option>';
                }
                $(that.config.selectors.region).html(options);
                $(that.config.selectors.city).html('<option>Город</option>');

                if (resolve) { // used in promise call
                    resolve('success');
                }
            },
            error: function(res) {

            }
        });
    },
    getCityList: function(regionId, url) {
        var that = this;
        $.ajax({
            url: url,
            data: {regionId: regionId, url: url},
            method: 'post',
            success: function(res) {
                var options = '<option>Город</option>';
                for (var i in res.cities) {
                    options += '<option value ="' + res.cities[i].id +'">'+ res.cities[i].name +'</option>';
                }
                $(that.config.selectors.city).html(options);
            },
            error: function(res) {

            }
        });
    }

};

$(document).ready(function(){
    EventForm.init();
});