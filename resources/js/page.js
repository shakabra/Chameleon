var page =
{
    div_count : 0,

    default_page :
    {
        id : "default_element",
        type : "div",

        markup : [
          "<h1>Hello World!</h1>",
          "<div id=\"output\"></div>",
          "<div id=\"input\"></div>"
        ]
    },


    load : function(element=this.default_page)
    {
      for (tags in element.markup)
      {
          document.write(element.markup[tags]);
      }
    },
    

    write : function(element)
    {
      document.write(element);
    },


    remove : function (id)
    {
        if (id) {
            document.getElementById(id).remove();
        }
    }
};
