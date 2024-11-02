// Real-time Character and Word Count Calculation
const textInput = document.getElementById("textInput");
const characterCount = document.getElementById("characterCount");
const wordCount = document.getElementById("wordCount");
const calculateButton = document.getElementById("calculateButton");

textInput.addEventListener("input", updateCounts);
calculateButton.addEventListener("click", saveToHistory);

function updateCounts() {
    const text = textInput.value;
    characterCount.textContent = text.length;
    wordCount.textContent = text.trim() ? text.trim().split(/\s+/).length : 0;
}

// Save calculation to history
function saveToHistory() {
    const text = textInput.value;
    if (text.trim()) {
        const history = JSON.parse(localStorage.getItem("history")) || [];
        history.push({ text: text, characters: text.length, words: text.trim().split(/\s+/).length });
        localStorage.setItem("history", JSON.stringify(history));
        alert("Calculation saved to history!");
    }
}

// Display history on history.html
const historyList = document.getElementById("historyList");
const clearHistoryButton = document.getElementById("clearHistoryButton");

if (historyList) {
    const history = JSON.parse(localStorage.getItem("history")) || [];
    history.forEach(entry => {
        const listItem = document.createElement("li");
        listItem.textContent = `"${entry.text}" - Characters: ${entry.characters}, Words: ${entry.words}`;
        historyList.appendChild(listItem);
    });
}

if (clearHistoryButton) {
    clearHistoryButton.addEventListener("click", () => {
        localStorage.removeItem("history");
        historyList.innerHTML = '';
        alert("History cleared!");
    });
}
