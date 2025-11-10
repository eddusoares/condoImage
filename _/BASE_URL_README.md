# Configuração BASE_URL para Ambientes Local e Produção

## 🎯 Objetivo
Esta implementação permite que a aplicação funcione corretamente tanto em desenvolvimento local quanto em produção, onde a URL base inclui o prefixo `/staging/`.

## 🔧 Como Configurar

### Ambiente Local (localhost)
No arquivo `.env`:
```
APP_URL=http://localhost
BASE_URL=
```

**Deixe `BASE_URL` vazio** para desenvolvimento local.

### Ambiente de Produção (staging)
No arquivo `.env`:
```
APP_URL=https://condoimage.com
BASE_URL=https://condoimage.com/staging
```

## 📝 Funções Implementadas

### 1. `baseUrl($path)`
Gera URLs considerando BASE_URL:
```php
baseUrl('condo-building') 
// Local: http://localhost/condo-building
// Produção: https://condoimage.com/staging/condo-building
```

### 2. `baseRoute($name, $parameters)`
Gera rotas do Laravel considerando BASE_URL:
```php
baseRoute('condo.building') 
// Local: http://localhost/condo-building
// Produção: https://condoimage.com/staging/condo-building
```

### 3. `baseAsset($path)`
Gera URLs de assets considerando BASE_URL:
```php
baseAsset('assets/css/main.css')
// Local: http://localhost/assets/css/main.css
// Produção: https://condoimage.com/staging/assets/css/main.css
```

## 🚀 Arquivos Modificados

### Layouts
- `layouts/frontend.blade.php` - CSS/JS assets e rotas
- `layouts/master.blade.php` - CSS/JS assets

### Helpers
- `app/Http/Helpers/helpers.php` - Adicionadas funções baseUrl, baseRoute, baseAsset

### Seções
- `sections/banner.blade.php` - Rotas do banner
- `sections/top_categories.blade.php` - Links dos cartões  
- `partials/header.blade.php` - Links do header
- `partials/listing_cards.blade.php` - Rotas de listagens

### JavaScript
- Variáveis globais `window.BASE_URL` e `window.APP_URL` disponíveis
- URLs construídas dinamicamente considerando BASE_URL

## ✅ Testes

### Local
```bash
# URLs devem funcionar:
http://localhost/
http://localhost/condo-building
http://localhost/neighborhood
http://localhost/assets/css/override.css
```

### Produção
```bash
# URLs devem funcionar:
https://condoimage.com/staging/
https://condoimage.com/staging/condo-building
https://condoimage.com/staging/neighborhood
https://condoimage.com/staging/assets/css/override.css
```

## 🔄 Migração

1. **Backup** do .env atual
2. **Adicionar** `BASE_URL=https://condoimage.com/staging` no .env de produção
3. **Manter** `BASE_URL=` vazio no .env local
4. **Testar** todas as rotas principais
5. **Verificar** se assets (CSS/JS) carregam corretamente

## ⚠️ Importante
- Sempre use as funções `baseUrl()`, `baseRoute()`, `baseAsset()` em novos códigos
- Nunca hardcode URLs com `http://localhost` ou domínios específicos
- Teste em ambos os ambientes antes de fazer deploy