import sqlite3
def crear_bds():
    conn = sqlite3.connect('ordenes.db')
    c = conn.cursor()
################################# TACOS #############################################
    c.execute('''
        CREATE TABLE IF NOT EXISTS tacos(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre VARCHAR,
            descri TEXT,
            precio DECIMAL,
            id_categoria TEXT,
            
        )
    ''')