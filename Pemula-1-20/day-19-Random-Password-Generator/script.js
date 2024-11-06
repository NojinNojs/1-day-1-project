// DOM Elements
const passwordOutput = document.getElementById('passwordOutput');
const lengthSlider = document.getElementById('passwordLength');
const lengthValue = document.getElementById('lengthValue');
const strengthBar = document.getElementById('strengthBar');
const strengthLabel = document.getElementById('strengthLabel');
const copyToast = document.getElementById('copyToast');
const passwordHistory = document.getElementById('passwordHistory');

// Password Generation Configuration
const config = {
    lowercase: 'abcdefghijklmnopqrstuvwxyz',
    uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    numbers: '0123456789',
    symbols: '!@#$%^&*()_+-=[]{}|;:,.<>?'
};

// Password History
let generatedPasswords = [];
const MAX_HISTORY = 5;

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Set initial state
    updateLengthValue();
    generatePassword();

    // Add event listeners
    lengthSlider.addEventListener('input', updateLengthValue);
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', validateCheckboxes);
    });
});

// Update length value display with animation
function updateLengthValue() {
    const value = lengthSlider.value;
    lengthValue.textContent = value;
    lengthValue.classList.add('pop');
    setTimeout(() => lengthValue.classList.remove('pop'), 200);
}

// Validate at least one checkbox is checked
function validateCheckboxes() {
    const checkboxes = [
        document.getElementById('uppercaseCheck'),
        document.getElementById('lowercaseCheck'),
        document.getElementById('numbersCheck'),
        document.getElementById('symbolsCheck')
    ];

    const anyChecked = checkboxes.some(cb => cb.checked);
    
    if (!anyChecked) {
        this.checked = true;
        showNotification('Please select at least one character type', 'warning');
    }
}

// Generate Password
function generatePassword() {
    const length = parseInt(lengthSlider.value);
    const useUpper = document.getElementById('uppercaseCheck').checked;
    const useLower = document.getElementById('lowercaseCheck').checked;
    const useNumbers = document.getElementById('numbersCheck').checked;
    const useSymbols = document.getElementById('symbolsCheck').checked;

    let chars = '';
    let password = '';

    // Build character set based on selected options
    if (useUpper) chars += config.uppercase;
    if (useLower) chars += config.lowercase;
    if (useNumbers) chars += config.numbers;
    if (useSymbols) chars += config.symbols;

    // Ensure at least one character from each selected type
    const requiredChars = [];
    if (useUpper) requiredChars.push(getRandomChar(config.uppercase));
    if (useLower) requiredChars.push(getRandomChar(config.lowercase));
    if (useNumbers) requiredChars.push(getRandomChar(config.numbers));
    if (useSymbols) requiredChars.push(getRandomChar(config.symbols));

    // Fill the rest with random characters
    for (let i = requiredChars.length; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        requiredChars.push(chars[randomIndex]);
    }

    // Shuffle the password
    password = shuffleArray(requiredChars).join('');

    // Update UI
    displayPassword(password);
    updateStrengthIndicator(password);
    addToHistory(password);

    // Animate generate button
    const generateBtn = document.querySelector('.generate-btn');
    generateBtn.classList.add('pulse');
    setTimeout(() => generateBtn.classList.remove('pulse'), 200);
}

// Get random character from string
function getRandomChar(str) {
    return str[Math.floor(Math.random() * str.length)];
}

// Fisher-Yates shuffle algorithm
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Display password with typing effect
function displayPassword(password) {
    let i = 0;
    passwordOutput.value = '';
    const typing = setInterval(() => {
        if (i < password.length) {
            passwordOutput.value += password[i];
            i++;
        } else {
            clearInterval(typing);
        }
    }, 50);
}

// Update strength indicator
function updateStrengthIndicator(password) {
    let strength = 0;
    const checks = {
        length: password.length >= 12,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        numbers: /[0-9]/.test(password),
        symbols: /[^A-Za-z0-9]/.test(password),
        noRepeating: !/(.)\1{2,}/.test(password)
    };

    // Calculate strength score
    strength += checks.length ? 25 : 10;
    strength += checks.uppercase ? 15 : 0;
    strength += checks.lowercase ? 15 : 0;
    strength += checks.numbers ? 20 : 0;
    strength += checks.symbols ? 25 : 0;
    strength += checks.noRepeating ? 10 : 0;

    // Normalize strength to 100
    strength = Math.min(100, strength);

    // Update UI
    strengthBar.style.width = `${strength}%`;
    
    // Update strength label and color
    let strengthText, strengthColor;
    if (strength < 40) {
        strengthText = 'Weak';
        strengthColor = '#e74c3c';
    } else if (strength < 70) {
        strengthText = 'Medium';
        strengthColor = '#f1c40f';
    } else {
        strengthText = 'Strong';
        strengthColor = '#2ecc71';
    }

    strengthLabel.textContent = strengthText;
    strengthLabel.className = `strength-label ${strengthText.toLowerCase()}`;
    strengthBar.style.backgroundColor = strengthColor;

    // Animate strength bar
    strengthBar.classList.add('updating');
    setTimeout(() => strengthBar.classList.remove('updating'), 500);
}

// Copy password to clipboard
async function copyToClipboard() {
    const password = passwordOutput.value;
    if (password === 'Click generate to create password') return;

    try {
        await navigator.clipboard.writeText(password);
        showNotification('Password copied to clipboard!', 'success');
        
        // Add copy animation
        const copyBtn = document.querySelector('.copy-btn');
        copyBtn.classList.add('copied');
        setTimeout(() => copyBtn.classList.remove('copied'), 1000);
    } catch (err) {
        showNotification('Failed to copy password', 'error');
    }
}

// Show notification
function showNotification(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
        <div class="toast-progress"></div>
    `;

    document.querySelector('.toast-container').appendChild(toast);

    // Remove toast after animation
    setTimeout(() => {
        toast.classList.add('hiding');
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Add password to history
function addToHistory(password) {
    generatedPasswords.unshift({
        password,
        timestamp: new Date().toLocaleString()
    });

    // Keep only last MAX_HISTORY items
    if (generatedPasswords.length > MAX_HISTORY) {
        generatedPasswords.pop();
    }

    updateHistoryUI();
}

// Update history UI
function updateHistoryUI() {
    if (!passwordHistory) return;

    passwordHistory.innerHTML = generatedPasswords.map(item => `
        <li class="history-item">
            <div class="password-info">
                <span class="password">${item.password}</span>
                <span class="timestamp">${item.timestamp}</span>
            </div>
            <button onclick="copyHistoryPassword('${item.password}')" class="copy-history-btn">
                <i class="fas fa-copy"></i>
            </button>
        </li>
    `).join('');
}

// Copy password from history
function copyHistoryPassword(password) {
    navigator.clipboard.writeText(password)
        .then(() => showNotification('Password copied from history!', 'success'))
        .catch(() => showNotification('Failed to copy password', 'error'));
}

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Generate new password with Enter
    if (e.key === 'Enter') {
        generatePassword();
    }
    // Copy password with Ctrl+C when password field is focused
    if (e.ctrlKey && e.key === 'c' && document.activeElement === passwordOutput) {
        copyToClipboard();
    }
});

// Add password strength tips
const strengthTips = {
    weak: [
        'Try making the password longer',
        'Add special characters',
        'Include numbers and symbols'
    ],
    medium: [
        'Add more variety of characters',
        'Increase password length',
        'Mix uppercase and lowercase'
    ],
    strong: [
        'Great password strength!',
        'Remember to store it securely',
        'Don\'t share it with anyone'
    ]
};

// Show random strength tip
function showStrengthTip() {
    const strength = strengthLabel.textContent.toLowerCase();
    const tips = strengthTips[strength];
    const randomTip = tips[Math.floor(Math.random() * tips.length)];
    showNotification(randomTip, strength);
}

// Easter egg: Konami code
let konamiCode = [];
const secretCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];

document.addEventListener('keydown', (e) => {
    konamiCode.push(e.key);
    konamiCode = konamiCode.slice(-10);
    
    if (konamiCode.join(',') === secretCode.join(',')) {
        document.body.classList.add('rainbow-mode');
        showNotification('🌈 Rainbow mode activated! 🌈', 'success');
        setTimeout(() => document.body.classList.remove('rainbow-mode'), 5000);
    }
});