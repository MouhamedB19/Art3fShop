import './bootstrap';

import { getConsent, setConsent, defaultPrefs, allAcceptedPrefs } from './cookie-consent';
window.cookieConsent = { getConsent, setConsent, defaultPrefs, allAcceptedPrefs };
