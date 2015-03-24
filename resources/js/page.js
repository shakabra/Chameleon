var page =
{
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
