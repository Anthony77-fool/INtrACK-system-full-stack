$(document).ready(function () {
  $('[title]').tooltip(); // Initial

  const observer = new MutationObserver(function () {
    $('[title]').tooltip(); // Reapply tooltips when new elements are added
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
});
