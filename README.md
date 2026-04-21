````md
# 🎮 Minecraft Player Manager (Pelican Fork)

🔗 Original project:  
https://github.com/kumagames-fou/minecraft-player-manager  

✨ Fork goal: Improve **RCON reliability** and **player status accuracy** for Pelican Panel.

---

## 🚀 Features

- 👥 Player list
- 🟢 Online / 🔴 Offline / 🚫 Banned / ⭐ OP status
- ⚡ Actions: OP, DEOP, Kick, Ban, Unban
- 📊 Player details:
  - Health ❤️
  - Food 🍗
  - Level 🧪
  - Gamemode 🎮
  - Inventory 🎒

---

## 🔧 Improvements in this fork

### 🔌 RCON Integration
- Custom settings:
  - `Host / IP`
  - `Port`
  - `Password`
- Uses RCON as **primary source**
- 🔁 Automatic fallback to panel commands

### 📡 Player Detection
- Priority: `RCON list`
- Fallback: UDP Query
- ✅ More accurate online status

### 🧠 Data Reliability
- Stable Online/Offline detection
- OP & Banned state preserved
- Improved live data parsing

### 🧩 Widgets
- More stable filters (Online / OP / Banned)
- Handles missing data safely

---

## ⚙️ Environment Variables

```env
MC_PLAYER_MANAGER_RCON_ENABLED
MC_PLAYER_MANAGER_RCON_HOST
MC_PLAYER_MANAGER_RCON_PORT
MC_PLAYER_MANAGER_RCON_PASSWORD
MC_PLAYER_MANAGER_NAV_SORT
````

---

## 🛠️ Recommended Setup

1. Enable RCON in `server.properties`

   ```properties
   enable-rcon=true
   ```

2. Set RCON password (same everywhere 🔐)

3. Configure plugin:

   * Host/IP 🌐
   * Port (default: `25575`)
   * Password

4. Ensure network access:

   * Panel ➜ Minecraft server

---

## 🧪 Troubleshooting

❌ Players not showing?

Check:

* ✔️ RCON enabled
* ✔️ Correct host / port / password
* ✔️ Firewall open
* ✔️ Server reachable from panel

💡 Optional:

* Enable UDP Query for fallback

---

## 📅 Info

* 🆕 Updated: 2026-04-21
* 🎯 Goal: Reliable player management via Pelican Panel

---

## ❤️ Notes

* Designed for **Pelican Panel environments**
* Works best with properly configured **RCON**

