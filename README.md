// キャッシュファイルの指定
var CACHE_NAME = 'pwa-sample-caches';
var urlsToCache = [
    '/poster-keisuke.github.io/',
];

// インストール処理
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// リソースフェッチ時のキャッシュロード処理
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches
            .match(event.request)
            .then(function(response) {
                return response ? response : fetch(event.request);
            })
    );
});
{
    "short_name": "PWA",
    "name": "PWA sample app",
    "display": "standalone",
    "start_url": "index.html",
    "icons": [
        {
            "src": "images/icon.jpg",
            "sizes": "192x192",
            "type": "image/jpg"
        }
    ]
}
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
　　<!-- vue.js　-->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <link rel="manifest" href="manifest.json">
    <title>PWA Sample</title>
  </head>
  <body>
    <div id="app">
        <p>{{ message }}</p>
        <button v-on:click="reverseMessage">Reverse Message</button>
     </div>
    <script>
    <!-- service workerの登録関係 -->
    if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service_worker.js').then(function(registration) {
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
        console.log('ServiceWorker registration failed: ', err);
    });
    }
    <!-- vue.jsの設定関係 -->
    var app = new Vue({
      el: '#app',
      data: {
        message: 'Hello Vue!'
      },
      methods: {
        reverseMessage: function () {
          this.message = this.message.split('').reverse().join('')
        }
      }
    });
    </script>
  </body>
</html>