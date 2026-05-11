# Saif Developers Portfolio — Setup Guide

## Files in this package
- index.html   → Main portfolio website
- send.php     → PHP backend (keeps Green API keys hidden from visitors)
- saif.webp    → Your profile photo
- README.md    → This file

---

## Step 1 — Add your Green API credentials

Open **send.php** and replace:
```
$instanceId = 'YOUR_INSTANCE_ID';
$apiToken   = 'YOUR_API_TOKEN';
```
Get these from: https://green-api.com  
→ Login → Create Instance → Copy Instance ID and API Token  
→ Scan the WhatsApp QR code inside the dashboard to authorize your number

---

## Step 2 — Deploy (requires PHP hosting)

The contact form needs PHP to run. Use any of these:

### Option A — Hostinger / cPanel hosting (recommended, ~$3/mo)
1. Upload all files to public_html/
2. Done — PHP runs automatically

### Option B — InfinityFree (free PHP hosting)
1. Sign up at infinityfree.com
2. Upload files via File Manager or FTP
3. Done

### Option C — Netlify/Vercel (static only — form won't work)
If you use static hosting, replace the fetch('send.php') in index.html
with a direct Green API call (the credentials will be visible in source).
Only use this if you don't mind that.

---

## Step 3 — Test
1. Open your site
2. Fill in the contact form and submit
3. You should receive a WhatsApp message on +92 309 7171127

---

## Customization tips
- To update your photo: replace saif.webp with a new file (keep the same name)
- To change Green API number: edit chatId in send.php
- To update brand list: edit the project cards in index.html

---

© 2026 Saif Developers
