import mysql.connector
import csv
import os
import time

# Configuração da conexão com o banco de dados (substitua com suas informações)
config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'plantdb'
}

ultima_hora_geracao = None  # Variável para armazenar a última hora de geração

while True:
    # Crie uma conexão com o banco de dados
    conn = mysql.connector.connect(**config)

    # Crie um cursor para executar consultas SQL
    cursor = conn.cursor()

    # Consulta SQL para obter a hora de geração da tabela no banco de dados
    query = "SELECT hora_geracao FROM hora WHERE id_hora = 1"
    cursor.execute(query)
    result = cursor.fetchone()

    # Verifique se há um resultado
    if result:
        hora_geracao = result[0]  # Obtém a hora de geração da tupla
        agora = time.strftime('%Y-%m-%d %H:%M:%S')

        # Verifique se a hora atual é maior ou igual à hora de geração
        if agora >= hora_geracao.strftime('%Y-%m-%d %H:%M:%S'):
            if ultima_hora_geracao != hora_geracao:
                ultima_hora_geracao = hora_geracao

                print("Geração Pendente")

                # Consulta SQL para recuperar os dados da base de dados (substitua com sua própria consulta)
                dados_query = """
    SELECT
        s.id_sensor,
        s.temperature,
        s.humidity,
        s.pressure,
        s.altitude,
        s.eCO2,
        s.eTVOC,
        CAST(CONV(RIGHT(s.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal
    FROM
        location AS l
    INNER JOIN
        sensors AS s
    ON
        l.id_sensor = s.id_sensor
    WHERE
        l.gerar = 1;
    """

                cursor.execute(dados_query)
                dados = cursor.fetchall()

                # Nome do arquivo CSV que você deseja gerar
                nome_arquivo_csv = "dados_da_base.csv"

                # Abra o arquivo CSV no modo de escrita
                with open(nome_arquivo_csv, mode='w', newline='') as arquivo_csv:
                    escritor_csv = csv.writer(arquivo_csv)

                    # Escreva o cabeçalho do CSV
                    escritor_csv.writerow(["Temperature", "Humidity", "Pressure", "Altitude", "eCO2", "eTVOC"])

                    # Escreva os dados recuperados no arquivo CSV
                    for linha in dados:
                        escritor_csv.writerow(linha)

                print(f"O arquivo CSV '{nome_arquivo_csv}' foi gerado com sucesso com base nos dados da base de dados.")

    # Feche o cursor e a conexão com o banco de dados
    cursor.close()
    conn.close()

    # Aguarde um minuto antes de verificar novamente
    time.sleep(60)


