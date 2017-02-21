/**
 * Created by dima on 2/21/17.
 */

function removeFilters(block)
{
    var tag = $(block).parent('.active-filter')
        .clone()    //clone the element
        .children() //select all the children
        .remove()   //remove all the children
        .end()  //again go back to selected element
        .text();

    var search = decodeURI(document.location.search);
    if (search.search(tag)) {
        var href = search.replace(tag, '');
        document.location.href = href;
    }
}