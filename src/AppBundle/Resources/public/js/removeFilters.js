/**
 * Created by dima on 2/21/17.
 */

function removeFilters(block)
{
    var tag = $(block).siblings('span').text().replace(/_/,' ');

    var search = decodeURI(document.location.search);
    var exists = search.search(tag);
    if (exists) {
        tag = search[exists - 1] + tag;
        var href = search.replace(tag, '');
        document.location.href = document.location.origin + document.location.pathname + href;
    }
}