document.querySelector('#search_with_filter').addEventListener('keypress', function(e) {
    const url = window.location.host;
    if(e.key == "Enter") {
      var filter = '?filter='+ e.target.value;
      window.location.href = window.location.protocol + "//" + url + window.location.pathname + filter
    }
});