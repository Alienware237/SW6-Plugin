document.addEventListener('DOMContentLoaded', function () {
    function openTab(evt, tabName) {
        var i, tabcontent, tablink;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablink = document.getElementsByClassName("tablink");
        for (i = 0; i < tablink.length; i++) {
            tablink[i].classList.remove("active");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }

    document.getElementById("enter-articles").style.display = "block";
});

