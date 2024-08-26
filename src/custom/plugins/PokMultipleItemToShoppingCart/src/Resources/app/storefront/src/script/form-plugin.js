import Plugin from 'src/plugin-system/plugin.class';

export default class FormPlugin extends Plugin {
    init() {
	    console.log("Hello from Form-plugin javascript file!");
        this._registerEvents();
        window.addEventListener('scroll', this.onScroll.bind(this));
    }

    onScroll() {
        console.log("Your plugin Javascript is working well!");
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            alert('Seems like there\'s nothing more to see here.');
        }
    }

    _registerEvents() {
        const tabEnterArticles = this.el.querySelector('#tab-enter-articles');
        const tabUploadCsv = this.el.querySelector('#tab-upload-csv');
        const enterArticlesContent = this.el.querySelector('#enter-articles-content');
        const uploadCsvContent = this.el.querySelector('#upload-csv-content');

        tabEnterArticles.addEventListener('click', () => {
                console.log("Tab for enter articles");
            this._toggleTabContent('enter-articles', enterArticlesContent, uploadCsvContent);
        });

        tabUploadCsv.addEventListener('click', () => {
                console.log("Tab for upload csv!");
            this._toggleTabContent('upload-csv', enterArticlesContent, uploadCsvContent);
        });
    }

    _toggleTabContent(activeTab, enterArticlesContent, uploadCsvContent) {
        if (activeTab === 'enter-articles') {
            enterArticlesContent.style.display = 'block';
            uploadCsvContent.style.display = 'none';
        } else if (activeTab === 'upload-csv') {
            enterArticlesContent.style.display = 'none';
            uploadCsvContent.style.display = 'block';
        }
    }
}
