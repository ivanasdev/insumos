CREATE TABLE [dbo].[tbl_RelSucursalInsumosA] (
  [id_RelSucIns] bigint  IDENTITY(1,1) NOT NULL,
  [id_Sucursal] int  NOT NULL,
  [st_InsumosA2] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_InsumosA3] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_InsumosA4] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_InsumosA5] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_InsumosA6] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_InsumosA7] varchar(max) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [st_AreasInsumos] varchar(255)  NULL,
  [id_FlagActivo] int  NULL
)  
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[tbl_RelSucursalInsumosA] SET (LOCK_ESCALATION = TABLE)