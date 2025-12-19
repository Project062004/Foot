// Firebase Configuration & Initialization
// This file is shared across login, register, and other auth pages.

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, signInWithPhoneNumber, RecaptchaVerifier } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyAxsJOMKTo42MeJZqhzOSMzbQyr_JaaoDs",
    authDomain: "wear-db-ab292.firebaseapp.com",
    projectId: "wear-db-ab292",
    storageBucket: "wear-db-ab292.firebasestorage.app",
    messagingSenderId: "1038851451730",
    appId: "1:1038851451730:web:3fa62b0f263efaf367688b",
    measurementId: "G-EWRPX82K5X"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
auth.languageCode = 'en';

// Expose functionality to global scope for simpler inline script usage if needed, 
// but primarily we export for modules.
window.firebaseApp = app;
window.firebaseAuth = auth;
window.RecaptchaVerifier = RecaptchaVerifier;
window.signInWithPhoneNumber = signInWithPhoneNumber;

// Custom Wrapper to handle Billing/Quota errors during development
const realSignInWithPhoneNumber = signInWithPhoneNumber;

window.signInWithPhoneNumber = (auth, phoneNumber, appVerifier) => {
    return realSignInWithPhoneNumber(auth, phoneNumber, appVerifier)
        .catch((error) => {
            if (error.code === 'auth/billing-not-enabled' || error.code === 'auth/quota-exceeded' || error.code === 'auth/too-many-requests') {
                console.warn("Firebase Billing/Quota/Limit Error intercepted. Falling back to MOCK mode for development.");
                alert("⚠️ Dev Mode: Firebase Limit/Billing Error. Using MOCK OTP.\n\nUse OTP: 123456");

                // Return a Mock ConfirmationResult object
                return Promise.resolve({
                    verificationId: "mock_verification_id",
                    confirm: (verificationCode) => {
                        // Accept specific mock code
                        if (verificationCode === '123456') {
                            return Promise.resolve({
                                user: {
                                    uid: "mock_user_" + phoneNumber,
                                    phoneNumber: phoneNumber,
                                    getIdToken: () => Promise.resolve("mock_id_token_12345")
                                }
                            });
                        } else {
                            return Promise.reject(new Error("Invalid Mock OTP"));
                        }
                    }
                });
            }
            throw error;
        });
};

console.log("Firebase Initialized (Dev Mode Enhanced)");

const customizedSignIn = window.signInWithPhoneNumber;
export { auth, customizedSignIn as signInWithPhoneNumber, RecaptchaVerifier };
