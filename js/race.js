
const typingDiv = document.getElementById("typing");
const wpmDiv = document.getElementById("wpm");
const wmDiv = document.getElementById("wm");
const timeDiv = document.getElementById("time");
const startGameBtn = document.getElementById("start-game");
const saveStatsBtn = document.getElementById("save");
const pharagraphs = [
  `Without imagination there is no hope, no chance to envision a better future, no place to go, no goal to reach.`,
  `My favorite activity is fishing. I like to catch walleye and catfish, and then cook them for breakfast.`,
  `The ISU and Iowa game was not close at all. At least the ISU fans were loyal!`,
  `The trumpet player in the marching band was playing very loudly as compared to the rest of the band.`,
  `Halloween is a holiday in October where children go around the neighborhood to beg for candy.`,
  `To help remember down the road, she writes her days activities in a journal every week.`,
  `The winding road lead down a steep mountain into a ravine. The water was high, so I could not pass.`
];
const startGame = () => {
  document.getElementById("all").style.display = "block";
  startGameBtn.classList.add("hidden");
  saveStatsBtn.classList.add("hidden");

  typingDiv.innerHTML = "";
  wpmDiv.innerHTML = "";
  wmDiv.innerHTML = "";
  timeDiv.innerHTML = "";
  // Choose random paragraph
  const text = pharagraphs[parseInt(Math.random() * pharagraphs.length)];
  const characters = text.split("").map((char) => {
    const span = document.createElement("span");
    span.innerText = char;
    typingDiv.appendChild(span);
    return span;
  });
  let cursorIndex = 0;
  let accuracy = 0;
  let cursorCharacter = characters[cursorIndex];
  cursorCharacter.classList.add("cursor");
  let startTime = null;
  const keydown = ({ key }) => {
    if (!startTime) {
      startTime = new Date();
    }
    if (key === cursorCharacter.innerText) {
      cursorCharacter.classList.remove("cursor");
      cursorCharacter.classList.add("done");
      cursorCharacter = characters[++cursorIndex];
    }
    else if (key != cursorCharacter.innerText) {
      accuracy++;
    }
    if (cursorIndex >= characters.length) {
      // game ended
      var endTime = new Date();
      var delta = endTime - startTime;
      var seconds = delta / 1000;
      var numberOfWords = text.split(" ").length;
      var wps = numberOfWords / seconds;
      var wpm = wps * 60.0;
    //   $.ajax({
    //     type: "POST",
    //     url: "../php/profile.php",
    //     data : {wpm : 'wpm'},
    //     success: function(data)
    //     {
    //         alert ("works");
    //       ;
    //     }
    // });
      document.getElementById("wpm").innerText = `wpm = ${parseInt(wpm)}`;
      document.getElementById("wm").innerHTML = `letters missed = ${parseInt(accuracy)}`;
      document.getElementById("time").innerHTML = `time to finish = ${parseFloat(seconds)}`
      document.removeEventListener("keydown", keydown);
      startGameBtn.classList.remove("hidden");  
      saveStatsBtn.classList.remove("hidden");

      return;
    }
    cursorCharacter.classList.add("cursor");
  };
  document.addEventListener("keydown", keydown);
};