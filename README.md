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

#Introduction about NukeViet
NukeViet is the first opensource CMS in Vietnam. The lastest version - NukeViet 4 coding ground up support lastest web technologies, include reponsive web design (use HTML 5, CSS 3, Composer, XTemplate), jQuery, Ajax...) enables you to build websites and online applications rapidly.

With it own core libraries built in, NukeViet 4 is cross platforms and frameworks independent. By basic knowledge of PHP and MySQL, you can easily extend NukeViet for your purposes.

NukeViet core is simply but powerful. It supports abstract modules which can be duplicate. So, it helps you create automatically many modules without any line of code from existing abstract modules.

NukeViet supports installing automatically modules, blocks, themes at Admin Control Panel and supports packing features which allow you to share your modules to web- community.

NukeViet fully supports multi-languages for internationalization and localization. Not only multi-interface languages but also multi-database languages are supported. NukeViet supports you to build new languages which are not distributed by NukeViet.

Detailed information about Nukeviet at Wikipedia Encyclopedia: http://vi.wikipedia.org/wiki/NukeViet

##Licensing
NukeViet is released under GNU/GPL version 2 or any later version.

See [LICENSE.txt](LICENSE.txt) for the full license.

##NukeViet official website
  - Home page - link to all resources NukeViet: http://nukeviet.vn (select Vietnamese to have the latest information).
  - NukeViet official Coding: http://code.nukeviet.vn
  - Theme, Module and more add-ons for NukeViet: http://nukeviet.vn/vi/store/
  - NukeViet official Forum http://forum.nukeviet.vn/
  - Open Document Library for NukeViet: http://wiki.nukeviet.vn/
  - NukeViet Translate Center: http://translate.nukeviet.vn/
  - NukeViet partner: http://nukeviet.vn/vi/partner/
  - NukeViet Education Center: http://nukeviet.edu.vn
  - NukeViet SaaS: http://nukeviet.com (testing)

##Community
  - NukeViet Fanpage: http://facebook.com/nukeviet
  - NukeViet group on FB: https://www.facebook.com/groups/nukeviet/
  - http://twitter.com/nukeviet
  - https://groups.google.com/forum/?fromgroups#!forum/nukeviet
  - http://google.com/+nukeviet



##Nukeviet Centre for Research and Development
VIETNAM OPEN SOURCE DEVELOPMENT JOINT STOCK COMPANY (VINADES.,JSC)

Website: http://vinades.vn | http://nukeviet.vn | http://nukeviet.com

Head Office:
  - Room 2004 - CT2 Nang Huong Building, 583 Nguyen Trai st, Ha Dong dist, Hanoi, Vietnam.
  - Phone: +84-4-85872007, Fax: +84-4-35500914, Email: contact (at) vinades.vn