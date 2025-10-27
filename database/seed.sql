INSERT INTO roles (name) VALUES
('owner'), ('admin'), ('editor'), ('support'), ('member');

INSERT INTO permissions (name) VALUES
('manage_services'), ('view_orders'), ('manage_orders'), ('manage_content'), ('manage_settings');

INSERT INTO role_user (role_id, user_id) VALUES (1,1);

INSERT INTO users (role, name, email, phone, password_hash, is_active, created_at) VALUES
('owner','Admin Kullanıcı','admin@example.com','+900000000000', '$2y$10$K1aXJz8Uq1iIvRFkR7dReuA1tO4z7Ih6Hv0a/8t4N8pZk19HxyFfm',1,NOW());

INSERT INTO categories (name, slug, is_active, sort, created_at) VALUES
('Instagram','instagram',1,1,NOW()),
('YouTube','youtube',1,2,NOW());

INSERT INTO services (category_id, name, slug, description, min_qty, max_qty, price_per_1000, tier_json, guarantee_days, is_active, provider_map_json, created_at) VALUES
(1,'Instagram Takipçi','instagram-takipci','Organik takipçi artışı sağlayan paket.',100,10000,199.90,'{"tiers":[{"min":100,"max":1000,"price":199.9}]}',30,1,'{}',NOW()),
(1,'Instagram Beğeni','instagram-begeni','Hızlı beğeni paketi.',50,5000,99.90,'{"tiers":[]}',7,1,'{}',NOW()),
(2,'YouTube İzlenme','youtube-izlenme','Kaliteli izlenme paketi.',500,20000,249.90,'{"tiers":[]}',14,1,'{}',NOW());

INSERT INTO coupons (code, type, value, starts_at, ends_at, usage_limit, used_count, is_active) VALUES
('HOSGELDIN','percent',10,NOW(),DATE_ADD(NOW(), INTERVAL 30 DAY),100,0,1);

INSERT INTO orders (user_id, service_id, quantity, unit_price, subtotal, coupon_id, discount_total, total, currency, status, external_ref, notes, created_at) VALUES
(1,1,1000,0.20,200.00,1,20.00,180.00,'TRY','completed','mock_1','Demo sipariş 1',NOW()),
(1,2,500,0.10,50.00,NULL,0.00,50.00,'TRY','processing','mock_2','Demo sipariş 2',NOW());

INSERT INTO payment_notifications (user_id, channel, amount, currency, status, meta_json, created_at) VALUES
(1,'bank',180.00,'TRY','approved','{"ref":"PN-001"}',NOW());

INSERT INTO tickets (user_id, subject, status, priority, created_at) VALUES
(1,'Teslimat Hakkında','open','medium',NOW());

INSERT INTO ticket_messages (ticket_id, user_id, admin_id, content, attachments_json, created_at) VALUES
(1,1,NULL,'Merhaba, siparişimin durumu nedir?','[]',NOW());

INSERT INTO contents (type, title, slug, body_html, meta_json, published_at, author_id) VALUES
('blog','SMM Stratejileri','smm-stratejileri','<p>En iyi SMM pratikleri burada.</p>','{}',NOW(),1),
('page','Hakkımızda','hakkimizda','<p>Kurumsal vizyonumuz...</p>','{}',NOW(),1);
