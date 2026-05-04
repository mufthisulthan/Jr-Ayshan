/**
 * ============================================
 * AUTH MODULE
 * Handles login, session, and validation
 * JR Marketing - Sri Lanka
 * ============================================
 */

const Auth = {
    SESSION_KEY: 'jr_session',
    REMEMBER_KEY: 'jr_remember',

    /**
     * Attempt login with username/password
     * Returns { success, user, message }
     */
    async login(username, password) {
        const trimUser = username.trim();
        const trimPass = password.trim();

        if (!trimUser || !trimPass) {
            return { success: false, message: 'Please enter your username and password.' };
        }

        try {
            const response = await fetch('/api/auth.php?action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ username: trimUser, password: trimPass })
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                return { success: false, message: result.message || 'Invalid username or password. Please try again.' };
            }

            const session = {
                user: result.user,
                shop: result.shop,
                loginTime: new Date().toISOString()
            };

            Utils.storage.set(this.SESSION_KEY, session);
            window.JR_SESSION = session;

            return { success: true, user: session.user, message: `Welcome, ${session.user.name}!` };
        } catch (error) {
            return { success: false, message: 'Unable to reach the login service.' };
        }
    },

    /**
     * Log out and clear session
     */
    logout() {
        fetch('/api/auth.php?action=logout', { method: 'POST', credentials: 'same-origin' }).catch(() => {});
        Utils.storage.remove(this.SESSION_KEY);
        window.JR_SESSION = null;
        window.location.href = 'index.php';
    },

    /**
     * Switch the active shop for the current session
     */
    async switchShop(shopId) {
        const response = await fetch('/api/auth.php?action=switch-shop', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ shopId: Number(shopId) })
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            return { success: false, message: result.message || 'Unable to switch shop.' };
        }

        const session = this.getSession();
        const nextSession = session ? { ...session, shop: result.shop } : { user: null, shop: result.shop };
        Utils.storage.set(this.SESSION_KEY, nextSession);
        window.JR_SESSION = nextSession;

        return { success: true, shop: result.shop };
    },

    /**
     * Check if user is logged in
     */
    isLoggedIn() {
        return !!this.getSession();
    },

    /**
     * Get current user session
     */
    getSession() {
        if (window.JR_SESSION) {
            return window.JR_SESSION;
        }

        return Utils.storage.get(this.SESSION_KEY);
    },

    /**
     * Save "Remember Me" username
     */
    saveRemember(username) {
        Utils.storage.set(this.REMEMBER_KEY, { username });
    },

    /**
     * Get saved username
     */
    getRemembered() {
        return Utils.storage.get(this.REMEMBER_KEY);
    },

    /**
     * Clear remembered username
     */
    clearRemember() {
        Utils.storage.remove(this.REMEMBER_KEY);
    },

    /**
     * Guard: redirect to login if not authenticated
     */
    requireAuth() {
        if (!this.isLoggedIn()) {
            window.location.href = 'index.php';
        }
    }
};

window.Auth = Auth;
