
## TR
### Kurulum
### Öncelikle projenin kurulabilmesi için cihazınızda node.js npm , php , composer, ve herhangi bir mysql veritabanı olması gerekir !
- İlk önce projenin ana dizinine girip cmd açın ve 'composer install' komutunu çalıştırarak laravelin gereksinimlerini kurun
- Laravelin bütün gereksinimlerini kurduktan sonra proje ana dizinindeki '.env.example' adlı dosyayı '.env' olarak değiştirin. Değiştirdiğiniz dosyadaki 'DB_' kısımlarını kendi veritabanı bilgilerinize göre ayarlayın. Sonrasında proje ana dizininde bir cmd açıp 'php artisan migrate' komutunu çalıştırın. Bu komut veritabanındaki bütün tabloları sizin için oluşturacaktır.
- Bu işlemlerden sonra proje ana dizinindeki açtığınız cmd de 'php artisan serve' yazarak backendi çalıştırabilirsiniz.
- Sonraki adım olarak 'frontend' klasörüne gelip burdada bir cmd açın ve 'npm install veya npm i' komutunu çalıştırarak frontend için gereksinimleri indirin.
- NPM bütün frontend gereksinimleri indirdikten sonra 'npm run dev' yazarak frontendi çalıştırabilirsiniz.
## EN
### Installation
### In order to install this project you need to Node.js npm, php and composer installed in your device !
- Firstly in the root of the project open a cmd and run the 'composer install' command. This command will install all of the laravel dependencies.
- After install all laravel dependencies in the root of the project there is a file named '.env.exmaple' change its name to '.env' and in this file you need to configure all the segments named 'DB_' acording to your database informations. After that open a cmd in the root of the project and run 'php artisan migrate' command. This command will create all the database tables for you.
- After all these steps run 'php artisan serve' command in the cmd that opened in the root of the project. This command will start backend.
- As the next step open a cmd in the 'frontend' folder and run 'npm install or npm i' command. This command will install all the dependencies for frontend.
- After npm install all the dependencies run 'npm run dev' command in the frontend folder. This command will start frontend.



  
