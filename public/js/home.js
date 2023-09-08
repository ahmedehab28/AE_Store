const scrollLeft = document.querySelector("#scroll-left");
const scrollRight = document.querySelector("#scroll-right");
const scrollContainer = document.querySelector(".overflow-auto");

scrollLeft.addEventListener("click", () => {
  scrollContainer.scrollLeft -= 200; // Adjust the scroll value to your liking
});

scrollRight.addEventListener("click", () => {
  scrollContainer.scrollLeft += 200; // Adjust the scroll value to your liking
});
