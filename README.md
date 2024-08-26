# SW6-Plugin



## Project Requirements

- Docker desktop (https://www.docker.com/products/docker-desktop/)
- Default credentials for Dockware: can be found at https://docs.dockware.io/use-dockware/default-credentials


## Running the Application

After cloning the project and accessing it via the command line:

### Starting Docker Containers

Adjust the port number if necessary based on the Docker configuration.

To start the application using Docker:
```
docker-compose up -d
```

### Accessing the Application Container

To access the Docker container for the application:
```
docker exec -it shopware-app bash
```

Adjust the permission of the folder inside the container:
```
sudo chown -R www-data:www-data /var/www/html/custom/plugins
```

### Installing Composer Dependencies

Install Composer dependencies manually if the vendor directory is not generated:
```
composer install
```

### Installing Vim (Optional)

To install Vim for editing project file via vim:
```
sudo apt-get install vim
```

Or you can add a new SFTP connection to your container:
Open the "src" folder with your preferred IDE and wait until it finishes loading.
Then add a new SFTP connection to your container. (Automatic-Upload is recommend if possible)
Now you are done and ready to develop your own plugins.


### Install The plugin

First update the list of plugins with the following command:
```
php bin/console plugin:refresh
```

Once the "PokMultipleItemToShoppingCart" plugin has been recognised by Shopware, we need to install it with the following command:
```
php bin/console plugin:install --activate PokMultipleItemToShoppingCart
```

### Build and Clear Cache

Run the following commands to build and clear the cache:
```
php bin/console cache:clear
./bin/build-storefront.sh
./bin/build-administration.sh
```

### Run the migration for the new Table
Run the migration to insert the new table into the database
```
bin/console database:migrate PokMultipleItemToShoppingCart --all
```


#### Access as Customer

- Open your web browser and navigate to: http://localhost/fast-items/add

You will certainly be redirected to the home page if you are trying to add items to the cart for the first time.
So please start by registering or log in by browsing: http://localhost/account/login


#### Access as Administrator
- Open your web browser and navigate to: http://localhost/admin#/login/

You will be redirected to the login page(use default Dockware credential):

```
Username: admin
Password: shopware
```

- Open The "My custom module" or "Customers operations" administration submodule under catalog:
- ![add multiple products to the shopping cart module](https://f005.backblazeb2.com/file/app-stored-image/image1.png)
