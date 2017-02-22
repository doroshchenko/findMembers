/*
/!**
 * Created by dima on 2/9/17.
 *!/

    function getRegionList(countryId, url, resolve = null) {
        var data = {
            countryId: countryId,
        };
        $.ajax({
            url: url,
            data: data,
            method: 'post',
            success: function(res) {
                var options = '<option>Регион</option>';
                for (var i in res.regions) {
                    options += '<option value ="' + res.regions[i].id +'">'+ res.regions[i].name +'</option>';
                }

                $('#form_region').html(options);
                $('#form_city').html('<option>Город</option>');

                if (resolve) { // used in promise call
                    resolve('success');
                }
            },
            error: function(res) {

            }
        });
    }

    function getCityList(regionId, url) {
        var data = {
            regionId: regionId,
            url: url
        };
        $.ajax({
            url: url,
            data: data,
            method: 'post',
            success: function(res) {
                var options = '<option>Город</option>';
                for (var i in res.cities) {
                    options += '<option value ="' + res.cities[i].id +'">'+ res.cities[i].name +'</option>';
                }
                $('#form_city').html(options);
            },
            error: function(res) {

            }
        });
    }


$(document).ready(function() {
    var regions = $('#form_region option'),
        cities = $('#form_city option');
    var countrySelected = $('#form_country').val(),
        regionSelected = $('#form_region').val();

    if (countrySelected) {
        let promise = new Promise((resolve,reject) => {
                getRegionList(countrySelected, '/web/app_dev.php/ajax/regions', resolve);
        });
        promise.then(
            result => {
                if (regionSelected) {
                    var regions = $('#form_region option');
                    $.each(regions, function(i, val) {
                        if ($(val).val() == regionSelected) {
                            $(val).attr('selected','selected');
                        }
                    });
                    getCityList(regionSelected,'/web/app_dev.php/ajax/cities');
                } else {
                cities.hide();
                }
            },
            error => {
                alert("Rejected: " + error);
        });
    } else {
        regions.hide();
        cities.hide();
    }
});*/
