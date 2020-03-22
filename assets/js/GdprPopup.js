// Styles
import '../css/GdprPopup.css';

export default class GdprPopup {
  /**
   * @param {Element|string} element
   * @param {Object=} options
   *
   * @constructor
   */
  constructor(element, options) {
    if (typeof element === 'string') {
      this.element = document.querySelector(element);
    } else {
      this.element = element;
    }

    if (!this.element) {
      return;
    }

    const defaultOptions = {
      cookieName: 'GDPR_COOKIE_LAW_CONSENT',
      agreementExpiresInDays: 30,
      autoAcceptCookiePolicy: false,
    };

    this.options = {...defaultOptions, ...options};

    // No need to display this if user already accepted the policy
    if (this.userAlreadyAcceptedCookies()) {
      return;
    }

    this.bindListeners();

    // In case it's alright to just display the message once
    if (this.options.autoAcceptCookiePolicy) {
      this.setUserAcceptsCookies(true);
    }
  }

  bindListeners() {
    this.element.querySelector('.gdprpopup-button-confirm').addEventListener('click', (e) => {
      e.preventDefault();

      this.setUserAcceptsCookies(true);
      this.removeContainer();

      return false;
    });

    this.element.querySelector('.gdprpopup-closebutton').addEventListener('click', (e) => {
      e.preventDefault();

      this.removeContainer();

      return false;
    });
  }

  // Storing the consent in a cookie
  setUserAcceptsCookies(consent) {
    let d = new Date();
    const expiresInDays = this.options.agreementExpiresInDays * 24 * 60 * 60 * 1000;
    d.setTime(d.getTime() + expiresInDays);
    const expires = "expires=" + d.toGMTString();
    document.cookie = this.options.cookieName + '=' + consent + "; " + expires + ";path=/";
  }

  // Let's see if we have a consent cookie already
  userAlreadyAcceptedCookies() {
    let userAcceptedCookies = false;
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
      const c = cookies[i].trim();
      if (c.indexOf(this.options.cookieName) === 0) {
        userAcceptedCookies = c.substring(this.options.cookieName.length + 1, c.length) !== '';
      }
    }

    return userAcceptedCookies;
  }

  removeContainer() {
    this.element.remove();
  }
}
