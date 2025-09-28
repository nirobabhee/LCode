document.addEventListener("keydown", function (e) {
   if (e.key === "s" && (e.ctrlKey || e.metaKey)) {
      e.preventDefault();
      document.getElementById("sform_submit").click();
   }
});