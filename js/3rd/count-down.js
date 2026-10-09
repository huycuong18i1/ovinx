"use strict";
function Util() { }
Util.setAttributes = function (el, attrs) {
    for (var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
};
(function () {
    var CountDown = function (element) {
        var labels = element.getAttribute("data-labels")
            ? element.getAttribute("data-labels").split(",")
            : [];
        var visibleLabels = element.getAttribute("data-visible-labels")
            ? element.getAttribute("data-visible-labels").split(",")
            : [];
        visibleLabels = visibleLabels.map(function (label) {
            return label.trim();
        });

        // create countdown HTML
        createCountDown(element, labels);

        // Store time elements
        var days = element.getElementsByClassName("js-countdown__value--0")[0];
        var hours = element.getElementsByClassName("js-countdown__value--1")[0];
        var mins = element.getElementsByClassName("js-countdown__value--2")[0];
        var secs = element.getElementsByClassName("js-countdown__value--3")[0];

        var endTime = getEndTime(element);

        // init counter
        initCountDown(element, endTime, days, hours, mins, secs, labels);
    };

    // Creates the countdown HTML structure
    function createCountDown(element, labels) {
        var wrapper = document.createElement("div");
        wrapper.setAttribute("aria-hidden", "true");
        wrapper.setAttribute("class", "countdown__timer");

        for (var i = 0; i < 4; i++) {
            var timeItem = document.createElement("span");
            var timeValue = document.createElement("span");
            var timeLabel = document.createElement("span");

            timeItem.setAttribute("class", "countdown__item");
            timeValue.setAttribute("class", "countdown__value countdown__value--" + i + " js-countdown__value--" + i);
            timeItem.appendChild(timeValue);

            if (labels && labels.length > 0) {
                timeLabel.textContent = labels[i].trim();
                timeLabel.setAttribute("class", "countdown__label");
                timeItem.appendChild(timeLabel);
            }

            wrapper.appendChild(timeItem);

            // `.cd-custom` (ovinx-html's `.countdown-v01`): " : " separator between the 4 boxes.
            if (i < 3 && element.classList.contains("cd-custom")) {
                var timeCustom = document.createElement("span");
                timeCustom.setAttribute("class", "countdown__custom");
                timeCustom.textContent = " : ";
                wrapper.appendChild(timeCustom);
            }
        }

        // Append new content to countdown element
        element.insertBefore(wrapper, element.firstChild);
    }

    // Get the end time for countdown
    function getEndTime(element) {
        if (element.getAttribute("data-timer")) {
            return Number(element.getAttribute("data-timer")) * 1000 + new Date().getTime();
        } else if (element.getAttribute("data-countdown")) {
            return Number(new Date(element.getAttribute("data-countdown")).getTime());
        }
    }

    // Initialize the countdown interval
    function initCountDown(element, endTime, days, hours, mins, secs, labels) {
        var intervalId = setInterval(function () {
            updateCountDown(element, endTime, days, hours, mins, secs, labels, intervalId);
        }, 1000);
        updateCountDown(element, endTime, days, hours, mins, secs, labels, intervalId);
    }

    // Update the countdown every second
    function updateCountDown(element, endTime, days, hours, mins, secs, labels, intervalId) {
        var time = parseInt((endTime - new Date().getTime()) / 1000);
        var daysRemaining = 0;
        var hoursRemaining = 0;
        var minsRemaining = 0;
        var secondsRemaining = 0;

        if (isNaN(time) || time < 0) {
            clearInterval(intervalId);
            emitEndEvent(element);
        } else {
            daysRemaining = parseInt(time / 86400);
            time = time % 86400;
            hoursRemaining = parseInt(time / 3600);
            time = time % 3600;
            minsRemaining = parseInt(time / 60);
            time = time % 60;
            secondsRemaining = parseInt(time);
        }

        if (!labels || labels.length < 4) {
            labels = ["Days", "Hours", "Mins", "Secs"];
        }

        var updatedLabels = [...labels];

        if (daysRemaining === 1) updatedLabels[0] = labels[0].replace(/s$/, "");
        if (hoursRemaining === 1) updatedLabels[1] = labels[1].replace(/s$/, "");
        if (minsRemaining === 1) updatedLabels[2] = labels[2].replace(/s$/, "");
        if (secondsRemaining === 1) updatedLabels[3] = labels[3].replace(/s$/, "");

        // `.cd-has-zero`: zero-pad every box ("08" not "8"), as in ovinx-html's count-down.js.
        var pad = element.classList.contains("cd-has-zero");
        days.textContent = getTimeFormat(daysRemaining, pad);
        hours.textContent = getTimeFormat(hoursRemaining, pad);
        mins.textContent = getTimeFormat(minsRemaining, pad);
        secs.textContent = getTimeFormat(secondsRemaining, pad);

        var countdownItems = element.getElementsByClassName("countdown__item");
        for (var i = 0; i < countdownItems.length; i++) {
            var labelEl = countdownItems[i].querySelector(".countdown__label");
            if (labelEl) {
                labelEl.textContent = updatedLabels[i];
            }
        }
    }

    // Format the time
    function getTimeFormat(time, pad) {
        return pad && time < 10 ? "0" + time : time.toString();
    }

    // Emit the countdown finished event
    function emitEndEvent(element) {
        var event = new CustomEvent("countDownFinished");
        element.dispatchEvent(event);
    }

    // Expose the CountDown function globally
    window.CountDown = CountDown;
})();