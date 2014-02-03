YUI.add('moodle-theme_cafe_con_leche-editbuttons', function(Y) {

/**
 * Splash theme colour switcher class.
 * Initialise this class by calling M.theme_splash.init
 */
var EditButtons = function() {
    EditButtons.superclass.constructor.apply(this, arguments);
};
EditButtons.prototype = {
    hasOverriddenDndUpload: false,
    editbutton: false,
    activeButton: null,
    initializer : function(config) {
        var self = this;
        if(!this.editbutton) {
            this.editbutton = Y.Node.create('<a href="#"></a>');
            this.editbutton.set('innerHTML', M.util.get_string('edit', 'moodle'));
            this.editbutton.addClass('cafe_con_leche-editbutton');
        }
        // Find all sets of icons and convert them to edit buttons
        Y.all('.commands').each(function(icons) {
            var buttons = icons.all('a');
            if (!buttons.isEmpty() && buttons.size() == 1) {
                icons.addClass('cafe_con_leche-noeditbutton');
            } else if(icons.getComputedStyle('display')=='none' && (!buttons.isEmpty() && icons.ancestor('.path-mod-forum #region-main')==null)) {
                self.processIcons(icons);
            }
        });

        // Delegated click handler for all edit buttons
        Y.delegate('click', function(e) {
            e = e || window.event;
            e.preventDefault();
            this.toggleButton(e.target);
        },
        'body', 'a.cafe_con_leche-editbutton', this);

        try {
            M.core_dock.on('dock:panelresizestart', function(e) {
                var item = M.core_dock.getActiveItem();
                if (item.cafe_con_leche_editbutton_done) {
                    this.all('.dockeditempanel_hd .hidepanelicon').remove();
                    item.fire('dockeditem:drawcomplete');
                    return;
                }
                var icons = this.one('.dockeditempanel_hd .commands');
                icons.all('.moveto span').remove()

                // Don't bother if it's only the undock and close icons
                if (icons.get('children').size()===2) {
                    icons.addClass('dock-commands');
                } else {
                    self.wrapButton(icons, self.editbutton.cloneNode(true));
                    var wrap = icons.ancestor();
                    // Put dock controls back outside edit button
                    wrap.append(icons.all('.moveto').remove());
                    wrap.append(icons.all('.hidepanelicon').remove());
                    item.commands = wrap.cloneNode(true);
                }
                item.cafe_con_leche_editbutton_done = true;
            }, M.core_dock.getPanel());

            var attachRemoveHandler = function(item) {
                item.on('dockeditem:itemremoved', function() {
                    var button = this.commands.ancestor('.header').one('.cafe_con_leche-editbutton-wrap');
                    if (button) button.remove();
                    if (!this.cafe_con_leche_editbutton_done && this.commands.hasChildNodes()) {
                        self.wrapButton(this.commands, self.editbutton.cloneNode(true));
                    }
                }, item);
            }
            M.core_dock.on('dock:itemadded', attachRemoveHandler, M.core_dock);
            Y.Array.each(M.core_dock.items, attachRemoveHandler);
        } catch(x) {}

        // Horribly nasty hack, since nothing in the dndupload chain fires any events we can listen for.
        // Since the dndupload module isn't there when we initialise, override its add_editing function
        // when we first see a "drop" on a section.
        // (could also be done with delays/setTimeout, but that's less reliable due to timing issues)
        var sections = Y.all('li.section.main');
        sections.each( function(el) {
            Y.on('drop', function(el) {
                if (!this.hasOverriddenDndUpload) {
                    var orig = M.course_dndupload.add_editing,
                    self = this;
                    M.course_dndupload.add_editing = function(elementid) {
                        self.processIcons(Y.one('#'+elementid+' .commands'));
                        orig(elementid);
                    }
                    this.hasOverriddenDndUpload = true;
                }
            }, el, this);
        }, this);
    },
    wrapButton : function(icons, button) {
        try{
            icons.wrap('<div class="cafe_con_leche-editbutton-wrap"></div>').insert(button, icons);
        } catch(x) {
            // Fallback for old versions of YUI without Node.wrap() (MDL20)
            var wrapper = Y.DOM.create('<div class="cafe_con_leche-editbutton-wrap"></div>');
            icons.ancestor().replaceChild(wrapper, icons);
            wrapper = Y.one(wrapper);
            wrapper.appendChild(icons);
            wrapper.insert(button, icons);
        }
    },
    processIcons : function(icons) {
        var thisbutton = this.editbutton.cloneNode(true);
        icons.all('a').each(function(tag) {
            var icon = tag.one('img');
            var caption = tag.get('title') || icon.get('title') || icon.get('alt');
            icon.removeAttribute('hspace');
            tag.append('<span>' + caption + '</span>');
            if(icon.get('src').match(/t%2Fhide/) || icon.get('src').match(/t%2Fshow/) || icon.get('src').match(/t%2Fgroup[nvs]/)) {
                tag.on('click', function(e, tag) {
                    window.setTimeout(function(){
                        var icon = tag.one('img');
                        var caption = tag.get('title') || icon.get('title') || icon.get('alt');
                        icon.removeAttribute('hspace');
                        tag.one('span').set('innerHTML', caption);
                    }, 1);
                }, this, tag);
            }
        });
        Y.later(1500, this, function(icons) {
            icons.all('span.editing_move').each(function(tag) {
                var icon = tag.one('img');
                var caption = tag.get('title') || icon.get('title') || icon.get('alt');
                icon.removeAttribute('hspace');
                tag.append('<span>' + caption + '</span>');
            });
        }, icons);
        this.wrapButton(icons, thisbutton);
    },
    toggleButton : function(button) {
        if(this.activeButton != null && this.activeButton != button) {
            this.toggleButton(this.activeButton);
            this.activeButton = button;
        } else if(this.activeButton == button) {
            this.activeButton = null;
        } else {
            this.activeButton = button;
        }
        button.ancestor().toggleClass('active');
        var mod = button.ancestor('li');
        if(mod) mod.toggleClass('cafe_con_leche-editbutton-active-module');
    }
};
// Make the colour switcher a fully fledged YUI module
Y.extend(EditButtons, Y.Base, EditButtons.prototype, {
    NAME : 'Caf� con Leche theme edit buttoniser',
    ATTRS : {
        // No attributes at present
    }
});
// Our splash theme namespace
M.theme_cafe_con_leche = M.theme_cafe_con_leche || {};
// Initialisation function for the colour switcher
M.theme_cafe_con_leche.initEditButtons = function(cfg) {
    return new EditButtons(cfg);
}

}, '@VERSION@', {requires:['base','node']});