# Owl Knowledge Extension for Owl Admin

这是一个基于 **Owl Admin** 的扩展包，用于管理知识库、知识分类、场景、可见性等功能，集成了多租户、AI 可见性控制。

---

## 📦 安装

通过 Composer 安装：

```bash
composer require fanxd/owl-knowledge:^1.0
```

如果是开发中本地调试，可以在 `extensions` 目录下直接做 symlink 或本地引用。

---

## 🚀 发布资源（可选）

如果该扩展提供了配置/视图/迁移资源，请执行：

```bash
php artisan vendor:publish --provider="DagaSmart\Knowledge\OwlKnowledgeServiceProvider"
```

选择需要发布的 tag，例如迁移、配置等。

---

## 🛠 数据迁移

执行数据库迁移，将扩展需要的表结构添加到数据库：

```bash
php artisan migrate
```

迁移将会：

✔ 添加知识场景表  
✔ 修改/增加知识分类、知识内容表字段  
✔ 增加可见性（visibility）、多租户（company_id/author_id）支持

如果需要回滚：

```bash
php artisan migrate:rollback
```

---

## 🤝 贡献者

欢迎提出 PR 和 Issue！

---

## 📄 许可证

本项目遵循 MIT 许可证，详情见 LICENSE。
