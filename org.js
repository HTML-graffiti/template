$(function() {
  $(".label").click(function() {
    $(".list li").removeClass("list_toggle");
  });
  if ($(".list li").hasClass("list_toggle")) {
    $(".reset .reset-button").click(function() {
    $(".list li").removeClass("is-hide");
    });
  }
});

var searchBox = ".search-box";
var listItem = ".list_item";
var hideClass = "is-hide";

$(function() {
  $(document).on("change", searchBox + " input", function() {
    search_filter();
  });
});

function search_filter() {
  $(listItem).removeClass(hideClass);
  for (var i = 0; i < $(searchBox).length; i++) {
    var name = $(searchBox)
      .eq(i)
      .find("input")
      .attr("name");
    var searchData = get_selected_input_items(name);
    if (searchData.length === 0 || searchData[0] === "") {
      continue;
    }
    for (var j = 0; j < $(listItem).length; j++) {
      var itemData = $(listItem)
        .eq(j)
        .data(name);
      if (searchData.indexOf(itemData) === -1) {
        $(listItem)
          .eq(j)
          .addClass(hideClass);
      }
    }
  }
}

function get_selected_input_items(name) {
  var searchData = [];
  $("[name=" + name + "]:checked").each(function() {
    searchData.push($(this).val());
  });
  return searchData;
}
