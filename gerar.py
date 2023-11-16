import mysql.connector
import csv
from datetime import datetime, time
import time as tm

# Configurações do banco de dados
db_config = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "plantdb",
}

# Nome do arquivo CSV
nome_arquivo = "dados_sensores.csv"

# Intervalo de verificação da hora (em segundos)
intervalo_verificacao = 60  # A cada minuto

try:
    while True:
        # Conecte-se ao banco de dados
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Consulta SQL para obter a hora de geração
        cursor.execute("SELECT id_hora,hora_geracao FROM hora where id_hora=1")
        hora_geracao = cursor.fetchone()[0]

        # Hora atual
        hora_atual = datetime.now().time()

        # Verifique se a hora atual é igual à hora de geração
        if hora_atual.strftime("%H:%M:%S") == hora_geracao.strftime("%H:%M:%S"):
            # Consulta SQL para obter os dados dos sensores com "gerar" igual a 1
            cursor.execute("SELECT * FROM sensors WHERE gerar = 1")

            # Recupere os resultados da consulta
            resultados = cursor.fetchall()

            # Crie o arquivo CSV e escreva os dados
            with open(nome_arquivo, "w", newline="") as arquivo_csv:
                csv_writer = csv.writer(arquivo_csv)

                # Escreva um cabeçalho CSV (opcional)
                # csv_writer.writerow(["Coluna1", "Coluna2", ...])

                # Escreva os dados dos sensores no arquivo CSV
                csv_writer.writerows(resultados)

            print("Arquivo CSV gerado com sucesso.")

        # Feche a conexão com o banco de dados
        cursor.close()
        conn.close()

        # Aguarde o intervalo de verificação antes de verificar novamente
        tm.sleep(intervalo_verificacao)

except KeyboardInterrupt:
    print("Script interrompido pelo usuário.")

except mysql.connector.Error as e:
    print(f"Falha na conexão ao banco de dados: {e}")
