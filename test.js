<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.10/d3.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/3.10.1/lodash.js"></script>

  <style>
    body {
      font-family: "Helvetica", Arial, "san-serif";
    }

    html {
      box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

    .container {
      width: 950px;
      margin: auto;
    }

    .day-calendar__create,
    .day-calendar__wrapper {
      display: inline-block;
      width: 300px;
      vertical-align: middle;
    }

    .day-calendar__wrapper {
      width: 650px;
      margin-left: 20px;
      position: relative;
      height: 500px;
      overflow: auto;
    }

    .day-calendar__background {
      position: absolute;
      width: 100%;
      background: #F5F5F5;
    }

    .day-calendar__background div {
      border-top: 1px solid #E2E2E2;
      width: 100%;
    }

    .day-calendar {
      width: 550px;
      margin: auto;
      position: relative;
      font-size: 15px;
    }

    .day-calendar__entry {
      position: absolute;
      background-color: #fff;
      padding: 2px;
      -webkit-transition: width .5s ease-in-out, left .5s ease-in-out, top .5s ease-in-out, height .5s ease-in-out;
      transition: width .5s ease-in-out, left .5s ease-in-out, top .5s ease-in-out, height .5s ease-in-out;
      cursor: pointer;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 14px;
      border-width: 1px;
      border-style: solid;
      border-left-width: 5px;
    }

    .day-calendar__create {
      width: 250px;
      margin: auto;
      border: 1px solid #D0D0D0;
      padding: 10px;
    }

    .day-calendar__create input {
      width: 50px;
      font-size: 15px;
    }

    .day-calendar__create textarea {
      font-size: 15px;
      width: 100%;
    }

    .day-calendar__create button {
      font-family: inherit;
      font-size: 100%;
      padding: 0.5em 1em;
      color: rgba(0, 0, 0, 0.80);
      /* rgba supported */
      border: none rgba(0, 0, 0, 0);
      background-color: #E6E6E6;
      text-decoration: none;
      border-radius: 2px;
    }
  </style>

</head>

<body>
  <div class="container">
    <div class="day-calendar__create">
      <form action="">
        <div class="summary-entry">
          <textarea name="summary" placeholder="add a new event"></textarea>
        </div>
        <div class="time-entry">
          <div>
            start
            <input type="text" name="start-hour" placeholder="00">
            <input type="text" name="start-minute" placeholder=00>
            <select class="start-select">
              <option value="am" selected>am</option>
              <option value="pm">pm</option>
            </select>
          </div>
          <div>
            end
            <input type="text" name="end-hour" placeholder="00">
            <input type="text" name="end-minute" placeholder="00">
            <select class="end-select">
              <option value="am">am</option>
              <option value="pm" selected>pm</option>
            </select>
          </div>

        </div>
        <br>

        <button>submit</button>
        <hr>
        <p>(click on an item to remove it)</p>
      </form>
    </div>
    <div class="day-calendar__wrapper">
      <div class="day-calendar__background"></div>
      <div class="day-calendar"></div>
    </div>
  </div>
  <script>

  	let calendarData = [
  {
    "summary": "Puppy meet-and-greet",
    "start": {
      "dateTime": "2016-01-12T07:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T21:00:00-05:00"
    }
  },
  {
    "summary": "Zoo animal conference",
    "start": {
      "dateTime": "2016-01-12T08:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T16:00:00-05:00"
    }
  },
  {
    "summary": "Breakfast meeting",
    "start": {
      "dateTime": "2016-01-12T07:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T07:30:00-05:00"
    }
  },
  {
    "summary": "Zoo field trip (weather allowing)",
    "start": {
      "dateTime": "2016-01-12T14:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T17:00:00-05:00"
    }
  },
  {
    "summary": "Keynote address by the Horse Whisperer",
    "start": {
      "dateTime": "2016-01-12T08:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T09:00:00-05:00"
    }
  },
  {
    "summary": "A closer look at sloths",
    "start": {
      "dateTime": "2016-01-12T07:50:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T14:00:00-05:00"
    }
  },
  {
    "summary": "The mysterious meerkat",
    "start": {
      "dateTime": "2016-01-12T11:30:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T12:30:00-05:00"
    }
  },
  {
    "summary": "Symposium: dolphins and you",
    "start": {
      "dateTime": "2016-01-12T12:30:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T13:30:00-05:00"
    }
  },
  {
    "summary": "Wrap Up Session",
    "start": {
      "dateTime": "2016-01-12T16:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T17:00:00-05:00"
    }
  },
  {
    "summary": "Drinks",
    "start": {
      "dateTime": "2016-01-12T19:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T20:30:00-05:00"
    }
  },
  {
    "summary": "Talent show",
    "start": {
      "dateTime": "2016-01-12T20:00:00-05:00"
    },
    "end": {
      "dateTime": "2016-01-12T21:00:00-05:00"
    }
  }
]
    var h = 600;
    var w = 550;

    //utility classes for date presentation
    function getDisplayHours(hours) {
      if (hours == 0) {
        return "" + 12;
      } else if (hours <= 12) {
        return "" + hours
      } else {
        return "" + (hours - 12);
      }
    }

    function getDisplayMinutes(m) {
      if (m > 9) return m;
      return m + "0";
    }

    function getDisplayTime(date) {
      var hours = getDisplayHours(date.getHours());
      var minutes = getDisplayMinutes(date.getMinutes());
      var ending = date.getHours() < 12 ? "am" : "pm";
      return hours + ":" + minutes + ending;
    }

    //load calendar data
    d3.json("data.json", function(error, data) {

      var colorScale = d3.scale.category10();

      //create hour-by-hour background
      d3.select(".day-calendar__background")
        .selectAll("div")
        .data(_.range(24))
        .enter()
        .append("div")
        .text(function(d) {
          if (d == 0) return "12 am"
          else if (d == 12) return "12 pm"
          else if (d > 12) return d - 12 + " pm"
          else return d + " am"
        })
        .style("height", h / 24 + "px")
        .style("width", w + "px");

      d3.select(".day-calendar")
        .style("height", h + "px");


      //for adding items to the calendar
      function createItem(e) {
        e.preventDefault();
        var newEntry = {
          start: {},
          end: {}
        };

        var inputs = [].slice.apply(document.querySelectorAll(".day-calendar__create input"));
        var textarea = document.querySelector(".day-calendar__create textarea");

        var times = inputs.map(function(input) {
          return parseInt(input.value) || 0;
        });

       var selects = [document.querySelector(".start-select").value, document.querySelector(".end-select").value];

        times = times.map(function(input, index){
          if (index % 2 !== 0) return input;

          var s = index == 0 ? selects[0] : selects[1];

            if (input == 12 &&  s == "am"){
              return 0;
            }
            else if (s == "am") {
              return input;
            }
            else if (input == 12 &&  s == "pm"){
              return 12;
            }
            else if (s == "pm"){
              return input + 12;
            }
        });

        //hacky way to set it to the same day
        newEntry.start.dateTime = new Date(calendarData[0].start.dateTime);
        newEntry.start.dateTime.setHours(times[0]);
        newEntry.start.dateTime.setMinutes(times[1]);
        newEntry.end.dateTime = new Date(calendarData[0].start.dateTime);
        newEntry.end.dateTime.setHours(times[2]);
        newEntry.end.dateTime.setMinutes(times[3]);

        newEntry.summary = textarea.value;

        //reset
        textarea.value = "";
        inputs.forEach(function(item) {
          item.value = "";
        });

        calendarData.push(newEntry);
        updateCalendar();

      }

      document.querySelector(".day-calendar__create button")
        .addEventListener("click", createItem, false);

      //enter, update, exit
      function updateCalendar() {

        //update calendarData
        makeLayout();

        //create calendar entries
        var calItems = d3.select(".day-calendar")
          .selectAll(".day-calendar__entry")
          .data(calendarData, function(d) {
            return d.id;
          });

        calItems
          .enter()
          .append("div")
          .classed("day-calendar__entry", true)
          .style("border-color", function(d, i) {
            return colorScale(i);
          })
          .style("top", function(d) {
            return d.layout.top * h/100 + "px";
          })
          .style("height", function(d) {
            return d.layout.height * h/100 + "px";
          })
          .on("click", function(d) {
            //just remove the item for now
            calendarData = calendarData.filter(function(item) {
              if (item !== d) return true
            });
            updateCalendar();
          })
          .attr("title", function(d){
            return d.summary;
          })
          .append("div")
          .classed("day-calendar__entry__text", true)
          .text(function(d) {
            return getDisplayTime(d.dateObj.start) + "-" + getDisplayTime(d.dateObj.end) + ": " + d.summary;
          });


        calItems
          .style("width", function(d) {
            //add some padding
            return (d.layout.width - 0.5) * w/100 + "px";
          })
          .style("left", function(d) {
            return d.layout.left * w/100 + "px";
          });

        calItems.exit()
          .style("width", "0px")
          .remove();


      } //end updateCalendar function

     // this actually calculates the layout
      function makeLayout() {

        calendarData.forEach(function(d) {
          if (!d.dateObj) {
            d.dateObj = {
              start : new Date(d.start.dateTime),
              end : new Date(d.end.dateTime)
            };

          }
          if (!d.id) {
            d.id = _.uniqueId('event');
          }
          if (!d.layout) {
            d.layout = {};
          }
        });

        //this needs to be sorted by time
        calendarData.sort(function(a, b) {
          if (a.dateObj.start < b.dateObj.start) return -1
          else if (b.dateObj.start < a.dateObj.start) return 1
        });

        //add top and height vals
        calendarData.forEach(function(d) {

          var minutesFromTop = d.dateObj.start.getHours() * 60 + d.dateObj.start.getMinutes();
          d.layout.top = minutesFromTop / (24 * 60) * 100;

          d.totalMinutes = (d.dateObj.end.getHours() * 60 + d.dateObj.end.getMinutes()) - (d.dateObj.start.getHours() * 60 + d.dateObj.start.getMinutes());
          d.layout.height = d.totalMinutes / (24 * 60) * 100;

        });

        calendarData.forEach(function(d) {

          d.layout.earlyOverlap = calendarData.filter(function(c) {
            if (c == d) return false;
            if (c.dateObj.start < d.dateObj.start && c.dateObj.end > d.dateObj.start) {
              return true
            } else if (d.dateObj.start.toString() == c.dateObj.start.toString()) {
              if (c.totalMinutes > d.totalMinutes) return true
              else if (c.totalMinutes === d.totalMinutes && c.id < d.id) return true;
            }
          });

          d.layout.lateOverlap = calendarData.filter(function(c) {
            if (c == d) return false;
            if (c.dateObj.start > d.dateObj.start && c.dateObj.start < d.dateObj.end) {
              return true
            } else if (d.dateObj.start.toString() == c.dateObj.start.toString()) {
              if (c.totalMinutes < d.totalMinutes) return true;
              else if (c.totalMinutes === d.totalMinutes && c.id > d.id) return true;
            }
          });

        });

        //what is the longest consecutive set of items that are to each item's right?
        //this will help determine the width
        calendarData.forEach(function(d) {
          var mostEntries = 0;

          function getLater(d, num) {
            //we've reached the end of a branch
            if (!d.layout.lateOverlap.length) {
              if (num > mostEntries) mostEntries = num;
            } else {
              num += 1;
              d.layout.lateOverlap.forEach(function(d) {
                return getLater(d, num)
              });
            }
          };
          getLater(d, 0);

          d.layout.maxRight = mostEntries;

        });

        //finally, calculate the widths
        calendarData.forEach(function(d) {

          function getWidthAndPosition(d) {
            var beforeWidth, immediatelyBefore;

            if (!d.layout.earlyOverlap.length) {
              beforeWidth = 0;
            } else {
              //because the sort might not be perfect
              immediatelyBefore = (function() {
                var farthestRight;
                d.layout.earlyOverlap.forEach(function(item) {
                  if (!farthestRight || item.layout.left > farthestRight.layout.left) {
                    farthestRight = item;
                  }
                });
                return farthestRight;
              })();

              beforeWidth = immediatelyBefore.layout.left + immediatelyBefore.layout.width;
            }

            //divide the remaining width equally between this block
            //and the later overlapping ones
            d.layout.width = (100 - beforeWidth) / (1 + d.layout.maxRight);
            d.layout.left = beforeWidth;

            d.layout.lateOverlap.forEach(function(l) {
              if (l.layout.earlyOverlap[l.layout.earlyOverlap.length - 1] == d) {
                getWidthAndPosition(l);
              }
            });

          } //end getWidth

          //it's a top level
          if (!d.layout.earlyOverlap.length) {
            getWidthAndPosition(d);
          }
        });

        return calendarData;

      }; //end makeLayout function





      //initial call
      updateCalendar();

    });
  </script>

</body>

</html>