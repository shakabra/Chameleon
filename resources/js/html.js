var html = function (type, spec={}) {
  html_element = [];

  if (page.hasOwnProperty(type + "_no"))
    ++page[type+"_no"];
  else
    page[type+"_no"] = 1;

  if (spec.hasOwnProperty("id"))
    id = spec.id;
  else
    id = type + "-" + page[type+"_no"];


  html_element["h"] = function() { 
    if (typeof spec === Object)
        text = spec.text;
    else
        text = spec;

    return "<" + type + " id=\"" + id + "\">" + text + "</" + type + ">";
  }

  html_element["h1"] = function() { return html_element["h"](); };
  html_element["h2"] = function() { return html_element["h"](); };
  html_element["h3"] = function() { return html_element["h"](); };
  html_element["h4"] = function() { return html_element["h"](); };
  html_element["h5"] = function() { return html_element["h"](); };
  html_element["p"] = function() { return html_element["h"](); };


  html_element["button"] = function() {
    spec.hasOwnProperty("value") ? value = spec.value : value = "";

    return "<button id=\"" + id + "\">" + value + "</button>";
  };


  html_element["table"] = function() {
    markup = "<table>";

    if (spec.cols) {
      markup += "<tr>";
      for (value in spec.cols) {
        markup += "<th>" + spec.cols[value] + "</th>";
      }
      markup += "</tr>";
    }

    while (spec.rows.length) {
      markup += "<tr>";

      for (data in (row = spec.rows.shift())) {
        markup += "<td>" + row[data] + "</td>";
      }

      markup += "</tr>";
    }

    return markup += "</table>";
  };


  return html_element[type]();
}
