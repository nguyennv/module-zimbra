# Module quản lý tài khoản mở rộng cho Zimbra
Các yêu cầu chính:
- Quản lý khởi tạo tài khoản, nhóm thư, địa chỉ thư... trên Zimbra CS.
- Phân cấp quản lý theo từng tên miền thư, nhóm tên miền, nhóm tài khoản... (Zimbra CS Open Source edition mặc định chỉ có một cấp quản trị toàn bộ hệ thống)
- Phù hợp với các hệ thống vừa và lớn (từ hàng ngàn tài khoản trở lên), hệ thống của các nhà cung cấp dịch vụ (cloud/service providers) và/hoặc các hệ thống cần tích hợp, phân cấp quản trị.

# Licensing
Module được phát hành theo giấy phép GNU Affero General Public License v3+. Xem toàn văn giấy phép trong tệp [LICENSE](LICENSE)

# Support
Dự án hỗ trợ bởi [Vinades](http://vinades.vn/) và [iWay](http://www.iwayvietnam.com/)

# Kế hoạch và tiến độ thực hiện
Lưu trữ tại: https://trello.com/b/rdJYzr2d/module-zimbra

# Yêu cầu chi tiết

##Dành cho Người quản trị domain/group (Domain/Group admin - mức 3)

###Quản trị Group/Distribution List (Nhóm thư)
- Tạo mới distribution list
- Cập nhật distribution list
- Xóa distribution list
  
###Quản trị Mailbox/Account (Tài khoản)
- Tạo mới account
- Cập nhật account
- Xóa account
- Đổi mật khẩu account

###Quản trị Alias (Địa chỉ thư)
- Tạo mới alias
- Cập nhật alias
- Xóa alias

##Dành cho Người quản trị Nhóm domain/group (Tenant - mức 2)

###Quản trị Domain (Tên miền)
- Tạo mới domain (đồng thời khởi tạo tài khoản người quản trị domain)
- Cập nhật domain
- Xóa domain

###Quản trị Group (Nhóm)
- Tạo mới group (đồng thời khởi tạo tài khoản người quản trị group)
- Cập nhật group
- Xóa group

###Thực hiện các quyền như với người quản trị domain/group (ở trên)
  
##Dành cho Người quản trị hệ thống (Supervisor - mức 1)

###Quản trị Tenant (người quản trị mức 2)
  * Tạo mới tenant (đồng thời khởi tạo tài khoản tenant)
  * Cập nhật tenant
  * Xóa tenant

###Thực hiện các quyền như với tenant (ở trên)

