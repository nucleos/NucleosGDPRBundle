import jQuery from 'jquery';

// Styles
import '../css/gdpr.css';

(function (jQuery) {
  "use strict";

  jQuery.fn.gdprCookieLawPopup = (function () {
    const _self = this;

    _self.params = {
      agreementExpiresInDays: 30,
      autoAcceptCookiePolicy: false
    };

    _self.vars = {
      INITIALISED: false,
      COOKIE_NAME: 'GDPR_COOKIE_LAW_CONSENT'
    };

    // Overwrite default parameters if any of those is present
    const parseParameters = function (settings) {
      if (settings) {
        if (typeof settings.agreementExpiresInDays !== 'undefined') {
          _self.params.agreementExpiresInDays = settings.agreementExpiresInDays;
        }
        if (typeof settings.autoAcceptCookiePolicy !== 'undefined') {
          _self.params.autoAcceptCookiePolicy = settings.autoAcceptCookiePolicy;
        }
      }
    };

    // Storing the consent in a cookie
    const setUserAcceptsCookies = function (consent) {
      let d = new Date();
      const expiresInDays = _self.params.agreementExpiresInDays * 24 * 60 * 60 * 1000;
      d.setTime(d.getTime() + expiresInDays);
      const expires = "expires=" + d.toGMTString();
      document.cookie = _self.vars.COOKIE_NAME + '=' + consent + "; " + expires + ";path=/";
    };

    // Let's see if we have a consent cookie already
    const userAlreadyAcceptedCookies = function () {
      let userAcceptedCookies = false;
      const cookies = document.cookie.split(";");
      for (let i = 0; i < cookies.length; i++) {
        const c = cookies[i].trim();
        if (c.indexOf(_self.vars.COOKIE_NAME) == 0) {
          userAcceptedCookies = c.substring(_self.vars.COOKIE_NAME.length + 1, c.length);
        }
      }

      return userAcceptedCookies;
    };

    const hideContainer = function () {
      jQuery('.gdprpopup-container').animate({
        opacity: 0,
        height: 0
      }, 200, function () {
        jQuery('.gdprpopup-container').hide(0);
      });
    };

    return {
      init: function (settings) {
        parseParameters(settings);

        // No need to display this if user already accepted the policy
        if (userAlreadyAcceptedCookies()) {
          return;
        }

        // We should initialise only once
        if (_self.vars.INITIALISED) {
          return;
        }
        _self.vars.INITIALISED = true;

        jQuery('.gdprpopup-button-confirm').click(function () {
          setUserAcceptsCookies(true);
          hideContainer();
          return false;
        });
        jQuery('.gdprpopup-closebutton').click(function () {
          hideContainer();
          return false;
        });

        // Ready to start!
        jQuery('.gdprpopup-container').show();

        // In case it's alright to just display the message once
        if (_self.params.autoAcceptCookiePolicy) {
          setUserAcceptsCookies(true);
        }
      }
    };
  });
}(jQuery));


jQuery(function () {
  jQuery(document).gdprCookieLawPopup().init();
});
