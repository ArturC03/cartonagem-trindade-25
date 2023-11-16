import mysql.connector
from datetime import datetime
import time

# Configurações do banco de dados
db_config = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "plantdb",
}

try:
    # Conecte-se ao banco de dados
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()

    while True:
        # Consulta SQL para obter a hora de geração
        cursor.execute("SELECT hora_geracao FROM hora WHERE id_hora = 1")
        hora_geracao = cursor.fetchone()[0]

        # Hora atual
        hora_atual = datetime.now().strftime("%H:%M:%S")

        # Verifique se a hora atual é igual à hora de geração
        if hora_atual == hora_geracao:
            print("A hora de geração foi alcançada!")

        # Aguarde um segundo antes de verificar novamente
        time.sleep(1)

except KeyboardInterrupt:
    print("Programa encerrado pelo usuário.")

except mysql.connector.Error as e:
    print(f"Falha na conexão ao banco de dados: {e}")
