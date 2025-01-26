function myFunction(x) {
  x.classList.toggle("change");
  var t = document.getElementById("side-nav");
  if (t.style.display === "block") {
    t.style.display = "none";
  } else {
    t.style.display = "block";
  }
  }
