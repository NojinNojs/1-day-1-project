# Digital Clock Project Documentation

## Overview
This project implements a digital clock that displays the current time using JavaScript. The clock updates every second and shows the current date along with a personalized greeting based on the time of day.

## Features
- **Real-Time Clock**: Displays the current time in hours, minutes, and seconds.
- **Date Display**: Shows the current date in a user-friendly format.
- **Dynamic Greeting**: Updates the greeting message based on the time of day (Good Morning, Good Afternoon, Good Evening, Good Night).
- **Dark/Light Mode Toggle**: Allows users to switch between dark and light themes for better visibility.

## Technologies Used
- **HTML**: Structure of the web page.
- **CSS**: Styling of the clock and layout.
- **JavaScript**: Functionality for updating the time, date, and greeting dynamically.

## Code Structure
- **index.html**: The main HTML file that contains the structure of the digital clock.
- **styles.css**: The CSS file that styles the clock and its components.
- **script.js**: The JavaScript file that contains the logic for updating the clock, date, and greeting.

## How It Works
1. The `updateClock` function retrieves the current time and formats it to display hours, minutes, and seconds.
2. The date is formatted to show the day of the week, month, and year.
3. The `updateGreeting` function changes the greeting message based on the current hour.
4. The clock updates every second using `setInterval`.
5. Users can toggle between dark and light modes using a button.

## Usage
To use this digital clock, simply open the `index.html` file in a web browser. The clock will automatically start displaying the current time and date.

## Contribution
Feel free to contribute to this project by adding new features or improving the existing code!

## License
This project is licensed under the MIT License.

Happy coding!
