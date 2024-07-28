module 1 :
- dang nhap 
- dang ky 
- dang xuat
- quen mat khau
- kich hoat tai khoan
module 2 :
- xac thuc nguoi dung dang nhap 
- them nguoi dung
- sua nguoi dung
- xoa nguoi dung
- hien thi danh sach nguoi dung
- phan trang , tim kiem , loc 
module 3 :
-thiet ke database
 - Bảng users 
 + id int primary key
 + email varchar (100)
 + fullname  varchar(50)
 + phone  varchar(20)
 + password varchar(50)
 + forgotToken varchar(50)
 + activeToken varchar(50)
 + status tiny int
 + createAt datetime
 + updateAt datetime
 Bảng loginToken
  + id int primary key
  + userID int foreign key đến users(id)
  + token varchar(50)
  + createAt datetime
- Xây dụng cấu trúc thư mục 
