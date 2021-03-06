USE [master]
GO
/****** Object:  Database [sales_pos]    Script Date: 18/07/2021 15:21:31 ******/
CREATE DATABASE [sales_pos]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'sales_pos', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\sales_pos.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'sales_pos_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\sales_pos_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [sales_pos] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [sales_pos].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [sales_pos] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [sales_pos] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [sales_pos] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [sales_pos] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [sales_pos] SET ARITHABORT OFF 
GO
ALTER DATABASE [sales_pos] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [sales_pos] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [sales_pos] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [sales_pos] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [sales_pos] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [sales_pos] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [sales_pos] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [sales_pos] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [sales_pos] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [sales_pos] SET  DISABLE_BROKER 
GO
ALTER DATABASE [sales_pos] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [sales_pos] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [sales_pos] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [sales_pos] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [sales_pos] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [sales_pos] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [sales_pos] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [sales_pos] SET RECOVERY FULL 
GO
ALTER DATABASE [sales_pos] SET  MULTI_USER 
GO
ALTER DATABASE [sales_pos] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [sales_pos] SET DB_CHAINING OFF 
GO
ALTER DATABASE [sales_pos] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [sales_pos] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [sales_pos] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [sales_pos] SET QUERY_STORE = OFF
GO
USE [sales_pos]
GO
/****** Object:  Table [dbo].[bn_category]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_category](
	[id_category] [int] IDENTITY(1,1) NOT NULL,
	[designation] [varchar](100) NOT NULL,
 CONSTRAINT [PK_bn_category] PRIMARY KEY CLUSTERED 
(
	[id_category] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_client]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_client](
	[id_client] [int] IDENTITY(1,1) NOT NULL,
	[firstname] [varchar](50) NOT NULL,
	[middlename] [varchar](50) NULL,
	[lastname] [varchar](50) NOT NULL,
	[address] [varchar](150) NULL,
	[idcard] [varchar](100) NULL,
	[phone] [varchar](50) NOT NULL,
	[addedBy] [varchar](50) NOT NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_client] PRIMARY KEY CLUSTERED 
(
	[id_client] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_guest_client]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_guest_client](
	[id_guestClient] [int] IDENTITY(1,1) NOT NULL,
	[id_client] [int] NULL,
	[phone] [varchar](15) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_guest_client] PRIMARY KEY CLUSTERED 
(
	[id_guestClient] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_iccid]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_iccid](
	[id_iccid] [int] IDENTITY(1,1) NOT NULL,
	[id_product] [int] NOT NULL,
	[iccid] [varchar](20) NULL,
	[msisdn] [varchar](20) NULL,
	[type] [varchar](50) NULL,
	[profile] [varchar](50) NULL,
	[id_pos] [int] NOT NULL,
	[addedBy] [varchar](50) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_iccid] PRIMARY KEY CLUSTERED 
(
	[id_iccid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_imei]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_imei](
	[id_imei] [int] IDENTITY(1,1) NOT NULL,
	[id_product] [int] NOT NULL,
	[imei] [varchar](20) NULL,
	[id_pos] [int] NULL,
	[creation_date] [datetime] NULL,
	[addedBy] [varchar](100) NULL,
 CONSTRAINT [PK_imei] PRIMARY KEY CLUSTERED 
(
	[id_imei] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_login]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_login](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](255) NOT NULL,
	[last_login] [datetime] NULL,
	[granted] [tinyint] NULL,
	[logout] [datetime] NULL,
	[usercheck] [varchar](10) NOT NULL,
	[ip] [varchar](50) NULL,
 CONSTRAINT [PK__migratio__3213E83F77B404C7] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_pages]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_pages](
	[id_page] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](250) NULL,
	[description] [text] NULL,
 CONSTRAINT [PK_bn_pages] PRIMARY KEY CLUSTERED 
(
	[id_page] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_plainte]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_plainte](
	[id_plainte] [int] IDENTITY(1,1) NOT NULL,
	[id_client] [int] NOT NULL,
	[id_type] [int] NOT NULL,
	[id_subtype] [int] NULL,
	[description] [text] NULL,
	[solution] [text] NULL,
	[status] [varchar](10) NULL,
	[addedBy] [varchar](50) NOT NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_plainte] PRIMARY KEY CLUSTERED 
(
	[id_plainte] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_pos]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_pos](
	[id_pos] [int] IDENTITY(1,1) NOT NULL,
	[designation] [varchar](100) NOT NULL,
	[city] [varchar](100) NULL,
	[province] [varchar](100) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_pos] PRIMARY KEY CLUSTERED 
(
	[id_pos] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_product]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_product](
	[id_product] [int] IDENTITY(1,1) NOT NULL,
	[code] [varchar](50) NULL,
	[designation] [varchar](200) NULL,
	[price] [decimal](18, 2) NULL,
	[id_category] [int] NOT NULL,
	[creation_date] [datetime] NULL,
	[addedBy] [varchar](100) NULL,
	[isDeleted] [tinyint] NULL,
	[deletedTime] [datetime] NULL,
	[deletedBy] [varchar](100) NULL,
	[modificationTime] [datetime] NULL,
	[modifyBy] [varchar](100) NULL,
 CONSTRAINT [PK_bn_product] PRIMARY KEY CLUSTERED 
(
	[id_product] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_product_hist]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_product_hist](
	[id_product] [int] NOT NULL,
	[code] [varchar](50) NULL,
	[designation] [varchar](200) NULL,
	[price] [decimal](18, 2) NULL,
	[id_category] [int] NOT NULL,
	[creation_date] [datetime] NULL,
	[addedBy] [varchar](100) NULL,
	[isDeleted] [tinyint] NULL,
	[deletedTime] [datetime] NULL,
	[deletedBy] [varchar](100) NULL,
	[modificationTime] [datetime] NULL,
	[modifyBy] [varchar](100) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_rate]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_rate](
	[id_rate] [int] IDENTITY(1,1) NOT NULL,
	[rate] [decimal](18, 2) NULL,
	[addedBy] [varchar](100) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_rate] PRIMARY KEY CLUSTERED 
(
	[id_rate] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_rate_hist]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_rate_hist](
	[id_rate_hist] [int] IDENTITY(1,1) NOT NULL,
	[id_rate] [int] NULL,
	[rate] [decimal](18, 2) NULL,
	[addedBy] [varchar](10) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_rate_hist] PRIMARY KEY CLUSTERED 
(
	[id_rate_hist] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_sale_extra]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_sale_extra](
	[id_sale_imei] [int] IDENTITY(1,1) NOT NULL,
	[id_sale] [int] NOT NULL,
	[id_product] [int] NOT NULL,
	[imei] [varchar](25) NULL,
	[msisdn] [char](9) NULL,
	[iccid] [varchar](50) NULL,
	[serial] [varchar](50) NULL,
 CONSTRAINT [PK_bn_sale_imei] PRIMARY KEY CLUSTERED 
(
	[id_sale_imei] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_sales]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_sales](
	[id_sale] [int] IDENTITY(1,1) NOT NULL,
	[id_client] [int] NOT NULL,
	[id_product] [int] NOT NULL,
	[id_ref] [int] NULL,
	[imei] [varchar](30) NULL,
	[quantity] [int] NOT NULL,
	[unit_price] [decimal](18, 2) NOT NULL,
	[total_price] [decimal](18, 2) NOT NULL,
	[addedBy] [varchar](50) NOT NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_sales] PRIMARY KEY CLUSTERED 
(
	[id_sale] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_sales_credit]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_sales_credit](
	[id_sale_credit] [int] NOT NULL,
	[id_product] [int] NOT NULL,
	[amount] [int] NULL,
	[phone] [varchar](15) NULL,
	[quantity] [int] NULL,
	[total_amount] [decimal](18, 2) NULL,
	[addedBy] [varchar](100) NULL,
	[creation_date] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_sales_exchange]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_sales_exchange](
	[id_exchange] [int] IDENTITY(1,1) NOT NULL,
	[id_plainte] [int] NULL,
	[id_ref] [int] NULL,
	[id_product] [int] NULL,
	[id_product_new] [int] NULL,
	[oldimei] [varchar](20) NULL,
	[newimei] [varchar](20) NULL,
	[addedBy] [varchar](50) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_sales_exchange] PRIMARY KEY CLUSTERED 
(
	[id_exchange] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_sales_reference]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_sales_reference](
	[id_ref] [int] IDENTITY(1,1) NOT NULL,
	[reference] [varchar](50) NOT NULL,
	[nbre_article] [int] NOT NULL,
	[total_price] [decimal](18, 2) NOT NULL,
	[id_client] [int] NULL,
	[creation_date] [datetime] NULL,
	[addedBy] [varchar](100) NULL,
 CONSTRAINT [PK_bn_sales_reference] PRIMARY KEY CLUSTERED 
(
	[id_ref] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_stock]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_stock](
	[id_stock] [int] IDENTITY(1,1) NOT NULL,
	[id_product] [int] NOT NULL,
	[quantity] [int] NOT NULL,
	[id_pos] [int] NOT NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_stock] PRIMARY KEY CLUSTERED 
(
	[id_stock] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_subtype_plainte]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_subtype_plainte](
	[id_subtype] [int] IDENTITY(1,1) NOT NULL,
	[id_type] [int] NOT NULL,
	[designation] [varchar](200) NULL,
	[creation_date] [datetime] NULL,
 CONSTRAINT [PK_bn_subtype_plainte] PRIMARY KEY CLUSTERED 
(
	[id_subtype] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_transaction]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_transaction](
	[id_trans] [int] IDENTITY(1,1) NOT NULL,
	[id_stock] [int] NOT NULL,
	[quantity] [int] NOT NULL,
	[id_pos] [int] NOT NULL,
	[creation_date] [datetime] NULL,
	[addedBy] [varchar](100) NULL,
 CONSTRAINT [PK_bn_transaction] PRIMARY KEY CLUSTERED 
(
	[id_trans] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_typeplainte]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_typeplainte](
	[id_type] [int] IDENTITY(1,1) NOT NULL,
	[designation] [varchar](150) NULL,
 CONSTRAINT [PK_bn_typeplainte] PRIMARY KEY CLUSTERED 
(
	[id_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[bn_user]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bn_user](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](50) NOT NULL,
	[password] [varchar](255) NOT NULL,
	[role] [varchar](50) NOT NULL,
	[status] [varchar](50) NULL,
	[names] [varchar](100) NOT NULL,
	[pages] [text] NULL,
	[addedBy] [varchar](50) NULL,
	[creation_date] [datetime] NULL,
	[id_pos] [int] NULL,
 CONSTRAINT [PK_bn_user] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[plainte_extra]    Script Date: 18/07/2021 15:21:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[plainte_extra](
	[id_extra] [int] IDENTITY(1,1) NOT NULL,
	[id_plainte] [int] NOT NULL,
	[facture] [varchar](20) NULL,
	[serial] [varchar](20) NULL,
	[imei] [varchar](25) NULL,
	[msisdn] [char](10) NULL,
	[evc] [char](10) NULL,
 CONSTRAINT [PK_plainte_extra] PRIMARY KEY CLUSTERED 
(
	[id_extra] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[bn_category] ON 

INSERT [dbo].[bn_category] ([id_category], [designation]) VALUES (1, N'Phone                                                                                               ')
INSERT [dbo].[bn_category] ([id_category], [designation]) VALUES (2, N'Modem                                                                                               ')
INSERT [dbo].[bn_category] ([id_category], [designation]) VALUES (3, N'Scratch                  ')
INSERT [dbo].[bn_category] ([id_category], [designation]) VALUES (4, N'EVoucher                                                                                            ')
INSERT [dbo].[bn_category] ([id_category], [designation]) VALUES (5, N'SIM')
SET IDENTITY_INSERT [dbo].[bn_category] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_client] ON 

INSERT [dbo].[bn_client] ([id_client], [firstname], [middlename], [lastname], [address], [idcard], [phone], [addedBy], [creation_date]) VALUES (1, N'mara', N'nseye', N'benjy', N'adresse 34', N'', N'09089787', N'africell', CAST(N'2021-07-15T09:48:20.440' AS DateTime))
INSERT [dbo].[bn_client] ([id_client], [firstname], [middlename], [lastname], [address], [idcard], [phone], [addedBy], [creation_date]) VALUES (2, N'max', N'miska', N'carl', N'adresse 34', N'', N'09089787', N'africell', CAST(N'2021-07-15T09:51:20.597' AS DateTime))
SET IDENTITY_INSERT [dbo].[bn_client] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_pages] ON 

INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (14, N'addUser', N'la page pour ajouter un utilisateur')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (15, N'deleteUser', N'la page pour supprimer un utilisateur')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (16, N'dashboard ', N'la page du tableau de bord')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (17, N'users', N'la page qui affiche tous les utilisateurs')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (18, N'logins', N'la page qui affiches toutes tentatives de connexion')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (19, N'editUser', N'la page pour modifier l''utilisateur')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (20, N'userProfile', N'les informations d''utilisateur')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (21, N'produits', N'listes des tous les produits')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (22, N'ajoutProduit', N'Ajouter les produits')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (23, N'clients', N'listes des tous les clients')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (24, N'editProduit', N'modifier les produits')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (25, N'ventes', N'liste de ventes')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (26, N'plaintes', N'Liste de toutes les plaintes')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1014, N'addPos', N'ajouter POS')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1015, N'addStock', N'ajouter le stock')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1017, N'imeis', N'tous les IMEI')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1018, N'addImei', N'Ajouter Imei de produit')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1019, N'iccids', N'liste iccid')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1020, N'addIccid', N'ajouter iccid')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1021, N'changests', N'change plainte statut')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1022, N'editProduct', N'modifier le produit')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1023, N'editRate', N'modifier le taux')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1024, N'generalreport', N'rapport general')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1025, N'orders', N'liste des  ventes')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1026, N'stock', N'liste de stock')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1027, N'userProfile', N'profile d''utilisateur')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1028, N'posreport', N'rapport par pos')
INSERT [dbo].[bn_pages] ([id_page], [name], [description]) VALUES (1029, N'rate', N'liste taux')
SET IDENTITY_INSERT [dbo].[bn_pages] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_pos] ON 

INSERT [dbo].[bn_pos] ([id_pos], [designation], [city], [province], [creation_date]) VALUES (1, N'NGIRI-NGIRI', N'KINSHASA', N'KINSHASA', CAST(N'2021-07-15T10:54:40.190' AS DateTime))
INSERT [dbo].[bn_pos] ([id_pos], [designation], [city], [province], [creation_date]) VALUES (2, N'MASINA', N'KINSHASA', N'KINSHASA', CAST(N'2021-07-15T12:44:35.977' AS DateTime))
SET IDENTITY_INSERT [dbo].[bn_pos] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_rate] ON 

INSERT [dbo].[bn_rate] ([id_rate], [rate], [addedBy], [creation_date]) VALUES (3, CAST(2000.00 AS Decimal(18, 2)), N'bnadmin', CAST(N'2021-05-27T14:25:02.393' AS DateTime))
SET IDENTITY_INSERT [dbo].[bn_rate] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_rate_hist] ON 

INSERT [dbo].[bn_rate_hist] ([id_rate_hist], [id_rate], [rate], [addedBy], [creation_date]) VALUES (1002, 2, CAST(2030.00 AS Decimal(18, 2)), N'bnadmin3', CAST(N'2020-12-08T08:45:39.630' AS DateTime))
SET IDENTITY_INSERT [dbo].[bn_rate_hist] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_subtype_plainte] ON 

INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (2, 1, N'ACHAT AFRIPHONE
', CAST(N'2021-06-02T11:33:31.577' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (3, 1, N'ACHAT MIFI
', CAST(N'2021-06-02T11:33:38.940' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (5, 1, N'ROUTER
', CAST(N'2021-06-02T11:34:09.413' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (6, 1, N'EVC
', CAST(N'2021-06-02T11:34:29.543' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (7, 1, N'SCRATCH CARD
', CAST(N'2021-06-02T11:34:35.140' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (8, 1, N'SMART PHONE
', CAST(N'2021-06-02T11:37:03.487' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (9, 2, N'SIM SWAP
', CAST(N'2021-06-02T11:39:43.570' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (10, 2, N'PERTE DE CREDIT
', CAST(N'2021-06-02T11:39:49.700' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (11, 2, N'CRBT
', CAST(N'2021-06-02T11:40:10.997' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (12, 2, N'RENOUVELLEMENT
', CAST(N'2021-06-02T11:40:22.453' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (13, 2, N'PUK
', CAST(N'2021-06-02T11:40:32.700' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (14, 2, N'CONNEXION
', CAST(N'2021-06-02T11:40:43.347' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (15, 2, N'COUVERTURE RESEAU
', CAST(N'2021-06-02T11:40:55.827' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (16, 2, N'MOBILE MONEY
', CAST(N'2021-06-02T11:41:01.347' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (17, 2, N'ENREGISTREMENT
', CAST(N'2021-06-02T11:41:20.043' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (18, 2, N'SOS
', CAST(N'2021-06-02T11:41:29.677' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (19, 2, N'TRANSFERT D''APPEL
', CAST(N'2021-06-02T11:41:39.993' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (20, 2, N'NUMERO MASQUE
', CAST(N'2021-06-02T11:41:49.910' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (21, 2, N'3G PROFIL
', CAST(N'2021-06-02T11:42:00.763' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (22, 2, N'4G PROFIL
', CAST(N'2021-06-02T11:42:13.770' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (23, 2, N'SIM BLOQUE
', CAST(N'2021-06-02T11:42:24.010' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (24, 2, N'APPEL INTERDIT
', CAST(N'2021-06-02T11:42:35.267' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (25, 2, N'PERTE DE FORFAIT
', CAST(N'2021-06-02T11:42:45.200' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (26, 2, N'SIGNAL INSTABLE
', CAST(N'2021-06-02T11:42:57.750' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (27, 2, N'SURFACTURATION
', CAST(N'2021-06-02T11:43:10.657' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (28, 2, N'RELEVE D''APPEL
', CAST(N'2021-06-02T11:43:27.183' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (29, 2, N'RELEVE DE CONSOMMATION DATA
', CAST(N'2021-06-02T11:44:33.697' AS DateTime))
INSERT [dbo].[bn_subtype_plainte] ([id_subtype], [id_type], [designation], [creation_date]) VALUES (30, 3, N'SUGGETION
', CAST(N'2021-06-02T11:44:42.907' AS DateTime))
SET IDENTITY_INSERT [dbo].[bn_subtype_plainte] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_typeplainte] ON 

INSERT [dbo].[bn_typeplainte] ([id_type], [designation]) VALUES (1, N'VENTE')
INSERT [dbo].[bn_typeplainte] ([id_type], [designation]) VALUES (2, N'SERVICE')
INSERT [dbo].[bn_typeplainte] ([id_type], [designation]) VALUES (3, N'SUGGESTION')
SET IDENTITY_INSERT [dbo].[bn_typeplainte] OFF
GO
SET IDENTITY_INSERT [dbo].[bn_user] ON 

INSERT [dbo].[bn_user] ([id], [username], [password], [role], [status], [names], [pages], [addedBy], [creation_date], [id_pos]) VALUES (7, N'africell', N'$2y$10$XL80eCw1tcP9iCeCyTVLwOgRsMG8SLEjD47CHxSwmJhWmUxgCt6.q', N'ADMIN', N'ACTIVE', N'myadmin', N'addUser;deleteUser;dashboard ;users;logins;editUser;userProfile;produits;ajoutProduit;clients;editProduit;ventes;plaintes;addPos;addStock;imeis;addImei;', N'bnadmin3', CAST(N'2020-12-08T13:35:02.877' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[bn_user] OFF
GO
SET IDENTITY_INSERT [dbo].[plainte_extra] ON 

INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (1, 1, N'', N'1', N'', N'          ', N'908765432 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (2, 2, N'', N'1', N'', N'          ', N'234567    ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (3, 3, N'', N'1', N'', N'          ', N'908765432 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (4, 4, N'', N'2', N'', N'          ', N'          ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (5, 5, N'', N'1', N'', N'          ', N'234567987 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (6, 6, N'', N'1', N'', N'          ', N'2345673222')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (7, 7, N'', N'1', N'', N'          ', N'908765432 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (8, 8, N'', N'1', N'', N'          ', N'9087654322')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (9, 9, N'', N'1', N'', N'          ', N'908765432 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (10, 10, N'', N'1', N'', N'          ', N'908765432 ')
INSERT [dbo].[plainte_extra] ([id_extra], [id_plainte], [facture], [serial], [imei], [msisdn], [evc]) VALUES (11, 11, N'', N'1', N'', N'          ', N'908765432 ')
SET IDENTITY_INSERT [dbo].[plainte_extra] OFF
GO
/****** Object:  Index [IX_bn_client]    Script Date: 18/07/2021 15:21:32 ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_bn_client] ON [dbo].[bn_client]
(
	[id_client] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [IX_bn_sales_reference]    Script Date: 18/07/2021 15:21:32 ******/
CREATE UNIQUE NONCLUSTERED INDEX [IX_bn_sales_reference] ON [dbo].[bn_sales_reference]
(
	[id_ref] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [IX_bn_user]    Script Date: 18/07/2021 15:21:32 ******/
ALTER TABLE [dbo].[bn_user] ADD  CONSTRAINT [IX_bn_user] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[bn_client] ADD  CONSTRAINT [DF_bn_client_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_guest_client] ADD  CONSTRAINT [DF_bn_guest_client_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_iccid] ADD  CONSTRAINT [DF_bn_iccid_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_imei] ADD  CONSTRAINT [DF_imei_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_login] ADD  CONSTRAINT [DF__migration__last___5FB337D6]  DEFAULT (getdate()) FOR [last_login]
GO
ALTER TABLE [dbo].[bn_login] ADD  CONSTRAINT [DF__migration__grant__60A75C0F]  DEFAULT ('0') FOR [granted]
GO
ALTER TABLE [dbo].[bn_login] ADD  CONSTRAINT [DF__migration__logou__619B8048]  DEFAULT (NULL) FOR [logout]
GO
ALTER TABLE [dbo].[bn_login] ADD  CONSTRAINT [DF__migration__userc__628FA481]  DEFAULT ('inconnu') FOR [usercheck]
GO
ALTER TABLE [dbo].[bn_login] ADD  CONSTRAINT [DF__migration_lo__ip__6383C8BA]  DEFAULT (NULL) FOR [ip]
GO
ALTER TABLE [dbo].[bn_plainte] ADD  CONSTRAINT [DF_bn_plainte_status]  DEFAULT (N'PENDING') FOR [status]
GO
ALTER TABLE [dbo].[bn_plainte] ADD  CONSTRAINT [DF_bn_plainte_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_pos] ADD  CONSTRAINT [DF_bn_pos_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_product] ADD  CONSTRAINT [DF_bn_product_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_product] ADD  CONSTRAINT [DF_bn_product_isDeleted]  DEFAULT ((0)) FOR [isDeleted]
GO
ALTER TABLE [dbo].[bn_product] ADD  CONSTRAINT [DF_bn_product_modificationTime]  DEFAULT (getdate()) FOR [modificationTime]
GO
ALTER TABLE [dbo].[bn_rate] ADD  CONSTRAINT [DF_bn_rate_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_rate_hist] ADD  CONSTRAINT [DF_bn_rate_hist_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_sales] ADD  CONSTRAINT [DF_bn_sales_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_sales_credit] ADD  CONSTRAINT [DF_bn_sales_credit_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_sales_exchange] ADD  CONSTRAINT [DF_bn_sales_exchange_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_sales_reference] ADD  CONSTRAINT [DF_bn_sales_reference_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_stock] ADD  CONSTRAINT [DF_bn_stock_quantity]  DEFAULT ((0)) FOR [quantity]
GO
ALTER TABLE [dbo].[bn_stock] ADD  CONSTRAINT [DF_bn_stock_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_subtype_plainte] ADD  CONSTRAINT [DF_bn_subtype_plainte_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_transaction] ADD  CONSTRAINT [DF_bn_transaction_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
ALTER TABLE [dbo].[bn_user] ADD  CONSTRAINT [DF_bn_user_creation_date]  DEFAULT (getdate()) FOR [creation_date]
GO
USE [master]
GO
ALTER DATABASE [sales_pos] SET  READ_WRITE 
GO
