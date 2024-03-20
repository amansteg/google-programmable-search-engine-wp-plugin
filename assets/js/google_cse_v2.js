  (function() {
    var cx = scriptParams.google_search_engine_id;  
    //var cx = '007604623310582658229:j5pu9nxyssu';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();




document.addEventListener('DOMContentLoaded', function() {
    const checkExist = setInterval(function() {
        const searchInput = document.getElementById('gsc-i-id1');
        if (searchInput) {
            clearInterval(checkExist); // Stop checking once the element is found

            const dynamicParts = [
                "Produkte",
                "Solarmodule",
                "Wechselrichter",
                "Balkonkraftwerk",
            ];
            let index = 0;
            let partIndex = 0;
            let typingForward = true;
            let placeholderBase = "Suche nach: ";

            const typePlaceholder = () => {
                let currentPart = dynamicParts[index];
                let currentPlaceholder = searchInput.getAttribute('placeholder') || placeholderBase;
                let currentLength = currentPlaceholder.length - placeholderBase.length;

                if (typingForward) {
                    if (currentLength < currentPart.length) {
                        searchInput.setAttribute('placeholder', placeholderBase + currentPart.substring(0, currentLength + 1));
                    } else {
                        typingForward = false;
                        setTimeout(typePlaceholder, 1000); // Adjust pause duration as needed
                        return;
                    }
                } else {
                    if (currentLength > 0) {
                        searchInput.setAttribute('placeholder', placeholderBase + currentPart.substring(0, currentLength - 1));
                    } else {
                        typingForward = true;
                        index = (index + 1) % dynamicParts.length;
                        setTimeout(typePlaceholder, 100); // Adjust delay before typing next part
                        return;
                    }
                }
                setTimeout(typePlaceholder, typingForward ? 120 : 60); // Adjust typing and deleting speed
            };

            // Initialize placeholder to ensure it's never null
            searchInput.setAttribute('placeholder', placeholderBase);
            // Start typing effect
            typePlaceholder();
        }
    }, 100); // Check every 100 milliseconds
});
