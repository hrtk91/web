# 起動
```docker-compose up -d```  
上記でlocalhostにアクセス可能となる。はず。  

# 落とす
```docker-compose down```

# DBマイグレーション
```docker exec -it web_app_1 php webapp/artisan migrate```  
これによりチャットソフトのDB整える  

# おまけ：シード
```docker exec -it web_app_1 php webapp/artisan db:seed```  
シードがあったらDBにデータ投入できる  
