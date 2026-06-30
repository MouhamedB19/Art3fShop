// resources/js/cookie-consent.js
// Petit helper pour lire/écrire le cookie de consentement RGPD.
// Pas de dépendance externe, cookie navigateur simple (365 jours).

const COOKIE_NAME = 'art3fshop_consent';
const COOKIE_DAYS = 365;

export function getConsent() {
    const match = document.cookie.match(new RegExp('(^| )' + COOKIE_NAME + '=([^;]+)'));
    if (!match) return null;

    try {
        return JSON.parse(decodeURIComponent(match[2]));
    } catch (e) {
        return null;
    }
}

export function setConsent(prefs) {
    const value = encodeURIComponent(JSON.stringify(prefs));
    const date = new Date();
    date.setTime(date.getTime() + COOKIE_DAYS * 24 * 60 * 60 * 1000);

    document.cookie = `${COOKIE_NAME}=${value}; expires=${date.toUTCString()}; path=/; SameSite=Lax`;
}

export function defaultPrefs() {
    return {
        necessaires: true,   // toujours true, non désactivable
        preferences: false,
        analytics: false,
        marketing: false,
        tiers: false,
    };
}

export function allAcceptedPrefs() {
    return {
        necessaires: true,
        preferences: true,
        analytics: true,
        marketing: true,
        tiers: true,
    };
}
