# Görev Atama ve Yönetim Sistemi

## 1. Giriş

### Projenin Amacı:
Farklı sağlayıcılardan görevleri çekmek, geliştiricilere bu görevleri atamak ve süreci yönetmek.

### Genel İşleyiş:
- `fetch:tasks` komutuyla görevlerin çekilmesi.
- Görevlerin `TaskAssignmentService` kullanılarak geliştiricilere atanması.
- API uç noktaları aracılığıyla görev ve görev atamalarının alınması.

## 2. Komut Tanımı ve Kullanımı

### fetch Komutu:
- Komut konumu: `app/Console/Commands/FetchTasks.php`
- `fetch:tasks` komutunu çalıştırarak sağlayıcılardan görevlerin çekilmesini ve veritabanına kaydedilmesini sağlar.
- Görevlerin çekilmesi ve kaydedilmesi işleminden sonra `TaskAssignmentService` sınıfı kullanılarak görevlerin geliştiricilere atanmasını gerçekleştirir.

#### Kod Yapısı:
```php
protected $signature = 'fetch:tasks';
protected $description = 'Fetch tasks from different providers and save them to the database';
```
Komut tanımı ve açıklaması bu şekilde belirlenmiştir.

#### Kullanımı: 
- Terminalde php artisan fetch:tasks komutuyla çalıştırılır.

## 3. ProviderService ve Görevlerin Çekilmesi
- ### ProviderServiceInterface:
  - Tüm görev sağlayıcılarının uyması gereken bir arayüz sağlar.
  - getProviderData() metodu, verilerin çekilmesi için kullanılacak olan metottur.
- ### ProviderService Sınıfı:
    - app/Service/Providers/ProviderService.php konumunda bulunur.
    - Görev sağlayıcılarından verileri çeker.
    - Sağlayıcı URL'lerini config/providers.php dosyasından alır ve her bir URL için GET isteği gönderir.
    - Gelen yanıtları JSON olarak parse eder ve döner. 

## 4. TaskAssignmentService ile Görev Atama
- ### TaskAssignmentService:
    - app/Service/TaskAssignmentService.php konumunda bulunur.
    - #### assignTask() metodu:
      - Veritabanındaki görevleri ve geliştiricileri alır.
      - Görevlerin zorluk seviyesini geliştiricilerin yetenekleriyle kıyaslayarak bir saat dilimi hesaplar.
      - Her geliştiriciye, uygun görevleri atar ve bu bilgiyi TaskAssignment modeline kaydeder.
- ### Atama Mantığı:
  - Görevlerin süresi ve zorluk seviyesi, geliştiricilerin zorluk çarpanı (difficulty multiplier) ile bölünür.
  - Geliştiricinin haftalık çalışma saatine göre hesaplanan görev süresi ile karşılaştırılır ve atama yapılır.

## 5. API Controller ile Verilerin Gösterimi
- ### APIController:
    - app/Http/Controllers/APIController.php konumunda bulunur.
    - Görev atama verilerini ve geliştirici bilgilerini JSON formatında döner.
    - #### API Uç Noktaları:
      - /api/tasks: Görevleri getirir.
      - /api/task-assignments: Görev atamalarını geliştiricilerle birlikte getirir.

## 6. Veri Modelleri ve İlişkiler
- ### Task Modeli
    - Görev verilerini içerir (name, duration, difficulty vb.)
- ### Developer Modeli:
    - Geliştirici bilgilerini içerir (name, difficulty_multiplier vb.)
- ### TaskAssignment Model
    - Görev ile geliştirici arasındaki atamayı içerir (task_id, developer_id, hours_allocated vb.)

## 7. Task Assignment Kullanımı
- ### TaskAssignmentService:
    - TaskFetched olayını dinler ve TaskAssignmentService'i kullanarak görev atamalarını gerçekleştirir.
- ### Görev Atamanın Çalışması:
    - fetch:tasks komutunun çalışmasıyla tetiklenen olay (TaskFetched) sonucunda TaskAssignmentService devreye girer ve görev atamasını gerçekleştirir. 

## 8. Örnek İşleyiş:
1. Adım: php artisan migrate komutunu çalıştırarak veritabanını ve ilgili tabloları oluşturun.
2. Adım:  php artisan db:seed komutu ile geliştiricileri veritabanına dahil edin.
3. Adım: php artisan fetch:tasks komutunu çalıştırın.
4. Adım: Sağlayıcıdan veriler çekilecek ve veritabanına kaydedilecek.
5. Adım: TaskAssignmentService kullanılarak görevler geliştiricilere atanacak.
6. Adım: /api/task-assignments API uç noktasına giderek atama verilerini görüntüleyin.
7. Adım:  npm run dev komutunu kullanarak JavaScript, CSS, Sass, Less, vb derleyicisini çalıştırın (Düzenleme yapılacaksa aktif edilmelidir) 
8. Adım:  npm run watch komutunu kullanarak kaynak dosyası izleyicisi ve otomatik derleyicisini aktif edin. (Düzenleme yapılacaksa aktif edilmelidir)    
9. Adım php artisan serve komutunu kullanarak sunucuyu çalıştırın.

## 9. Notlar:
- Görev atamaları, geliştiricilerin yeteneklerine ve görevlerin zorluk seviyelerine göre yapılır.
- Mail ile verilen mock server yanıtları hatalı ve eksik olduğu için tarafımca düzeltilip /api/tasks adresine eklenmiş ve oradan çekilmiştir.
