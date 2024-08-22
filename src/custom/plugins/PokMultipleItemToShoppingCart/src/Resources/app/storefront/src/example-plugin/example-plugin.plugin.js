import Plugin from 'src/plugin-system/plugin.class';

export default class ExamplePlugin extends Plugin {
    init() {
        // Ensure the DOM is fully loaded before running the script
        
            console.log("Hello from Form-plugin javascript file!");

            // Check if the elements exist before registering events
            this.tabEnterArticles = this.el.querySelector('#tab-enter-articles');
            this.tabUploadCsv = this.el.querySelector('#tab-upload-csv');
            this.enterArticlesContent = this.el.querySelector('#enter-articles');
            this.uploadCsvContent = this.el.querySelector('#upload-csv');

            if (this.tabEnterArticles && this.tabUploadCsv) {
		console.log("Elements are founding!");
                this._registerEvents();
            } else {
                console.error("Tab elements not found!");
            }

            // Adding scroll event as an example
            // window.addEventListener('scroll', this.onScroll.bind(this));
        
    }

    onScroll() {
        console.log("Your plugin Javascript is working well!");
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            alert('Seems like there\'s nothing more to see here.');
        }
    }

    _registerEvents() {
        console.log("Colling register events!");
	console.log(this.tabEnterArticles);
        this.tabEnterArticles.addEventListener('click', () => {
            console.log("Tab for enter articles clicked");
            this._toggleTabContent('enter-articles');
            this._toggleActiveButton(this.tabEnterArticles, this.tabUploadCsv);
        });

	console.log(this.tabUploadCsv);
        this.tabUploadCsv.addEventListener('click', () => {
            console.log("Tab for upload csv clicked!");
            this._toggleTabContent('upload-csv');
            this._toggleActiveButton(this.tabUploadCsv, this.tabEnterArticles);
	}); 
    }

    _toggleTabContent(activeTab) {
        if (activeTab === 'enter-articles') {
            this.enterArticlesContent.style.display = 'block';
            this.uploadCsvContent.style.display = 'none';
        } else if (activeTab === 'upload-csv') {
            this.enterArticlesContent.style.display = 'none';
            this.uploadCsvContent.style.display = 'block';
        }
    }

    // Toggle active button styles
    _toggleActiveButton(activeButton, inactiveButton) {
        // Add 'active' class to the clicked button
        activeButton.classList.add('active');
        // Remove 'active' class from the other button
        inactiveButton.classList.remove('active');
    }
}

