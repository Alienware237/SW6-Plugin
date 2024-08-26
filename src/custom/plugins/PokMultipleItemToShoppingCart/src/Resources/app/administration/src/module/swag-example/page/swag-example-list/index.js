import template from './swag-example-list.html.twig';
import Criteria from 'shopware/core/data/criteria'; // Import Criteria if available

Shopware.Component.register('swag-example-list', {
    template,

    inject: ['repositoryFactory'],  // Inject repositoryFactory
    
    created() {
        this.loadLogs();
    },

    data() {
        return {
            logs: [],
            columns: [
                { property: 'customer_id', label: 'Customer ID' },
                { property: 'product_number', label: 'Product Number' },
                { property: 'quantity', label: 'Quantity' },
                { property: 'created_at', label: 'Created At' },
                { property: 'actions', label: 'Actions' }
            ],
            isLoading: false  // Track loading state
        };
    },

    methods: {
        loadLogs() {
            this.isLoading = true;
            // Construct the URL to call the API endpoint
            const url = '/fast-Operations';

            // Prepare request options
            const options = {
                method: 'POST', // Use 'GET' if you don't need to send any request body
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    filters: {
                        // Add your filters here if needed
                    }
                })
            };

            // Fetch data from the API endpoint
            fetch(url, options)
                .then(response => response.json())
                .then(data => {

                    // Access the 'data' property and transform it into an array
    this.logs = Object.values(data.data).map(record => ({
        customer_id: record.customerId,
        product_number: record.product?.productNumber || 'N/A', // Accessing the productNumber from the product object
        quantity: record.quantity,
        created_at: record.createdAt,
        updated_at: record.updatedAt
    }));

                    this.isLoading = false;  // Stop loading
                })
                .catch(error => {
                    console.error('Error loading logs:', error);
                    this.isLoading = false;  // Stop loading on error
                });
        },

        viewDetails(item) {
            console.log(item);  // Implement your logic for viewing details
        }
    }
});

