import qrcode

# URL para o QR Code
url = "https://www.sp.senac.br/bemestar-portal/home"

# Gerar o QR Code
qr = qrcode.QRCode(
    version=1,
    error_correction=qrcode.constants.ERROR_CORRECT_L,
    box_size=10,
    border=4,
)
qr.add_data(url)
qr.make(fit=True)

# Criar a imagem do QR Code
img = qr.make_image(fill_color="black", back_color="white")

# Salvar a imagem
img.save("public/storage/qrcode_bemestar.png")
print("QR Code gerado e salvo em public/storage/qrcode_bemestar.png")