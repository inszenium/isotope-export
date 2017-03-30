/**
 * IsotopeOrderExport
 *
 * @copyright  inszenium 2016 <https://inszenium.de>
 * @author     Kirsten Roschanski <kirsten.roschanski@inszenium.de>
 * @package    IsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/inszenium/isotope-export
 * @filesource
 */


var IsotopeExport =
{
  initializeToolsMenu: function()
  {
    var tools = document.getElements('#tl_buttons .isotope-export');

    if (tools.length < 1)
      return;

    // Remove the separators between each button
    tools.each(function(node) {
      node.previousSibling.nodeValue = '';
    });

    // Add trigger to tools buttons
    document.getElement('a.header_isotope-export').addEvent('click', function(e)
    {
      document.id('isotopetoolsmenu').setStyle('display', 'block');
      return false;
    })
    .setStyle('display', 'inline');

    var div = new Element('div',
    {
      'id': 'isotopetoolsmenu',
      'styles': {
        'top': ($$('a.header_isotope-export')[0].getPosition().y + 22)
      }
    })
    .adopt(tools)
    .inject(document.id(document.body))
    .setStyle('left', $$('a.header_isotope-export')[0].getPosition().x - 230);

    // Hide context menu
    document.id(document.body).addEvent('click', function()
    {
      document.id('isotopetoolsmenu').setStyle('display', 'none');
    });
  },


  initializeToolsButton: function()
  {
    // Hide the tool buttons
    document.getElements('#tl_listing .isotope-tools, .tl_listing .isotope-tools').addClass('invisible');

    // Add trigger to edit buttons
    document.getElements('a.isotope-contextmenu').each(function(el)
    {
      if (el.getNext('a.isotope-tools'))
      {
        el.removeClass('invisible').addEvent('click', function(e)
        {
          if ($defined(document.id('isotope-contextmenu')))
          {
            document.id('isotope-contextmenu').destroy();
          }

          var div = new Element('div',
          {
            'id': 'isotope-contextmenu',
            'styles': {
              'top': (el.getPosition().y + 22),
              'display': 'block'
            }
          });

          el.getAllNext('a.isotope-tools').each( function(el2)
          {
            var im2 = el2.getFirst('img');
            new Element('a', {
              'href': el2.get('href'),
              'title': el2.get('title'),
              'html': (el2.get('html') +' '+ im2.get('alt'))
            }).inject(div);
          });

          div.inject(document.id(document.body));
          div.setStyle('left', el.getPosition().x - (div.getSize().x / 2));

          return false;
        });
      }
    });

    // Hide context menu
    document.id(document.body).addEvent('click', function(e)
    {
      if ($defined(document.id('isotope-contextmenu')) && !e.target.getParent('#isotope-contextmenu'))
      {
        document.id('isotope-contextmenu').destroy();
      }
    });
  }
};

window.addEvent('domready', function()
{
  IsotopeExport.initializeToolsMenu();
  IsotopeExport.initializeToolsButton();
}).addEvent('structure', function()
{
  IsotopeExport.initializeToolsButton();
});
