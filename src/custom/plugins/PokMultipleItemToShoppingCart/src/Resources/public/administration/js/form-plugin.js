document.addEventListener('DOMContentLoaded', function() {
    var tabEnterArticles = document.getElementById('tab-enter-articles');
    var tabUploadCsv = document.getElementById('tab-upload-csv');
    var enterArticlesContent = document.getElementById('enter-articles-content');
    var uploadCsvContent = document.getElementById('upload-csv-content');

    tabEnterArticles.addEventListener('click', function() {
        console.log("Tab to enter the article!");
        enterArticlesContent.style.display = 'block';
        uploadCsvContent.style.display = 'none';
    });

    tabUploadCsv.addEventListener('click', function() {
        console.log("Upload csv-content!");
        enterArticlesContent.style.display = 'none';
        uploadCsvContent.style.display = 'block';
    });
});
