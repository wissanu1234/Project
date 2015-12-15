--------------------------------------------------------
--  DDL for Table PACKAGE
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."PACKAGE" 
   (	"PACKAGE_NO" VARCHAR2(20 BYTE), 
	"PACKAGE_NAME" VARCHAR2(100 BYTE), 
	"PRICE" NUMBER(*,0), 
	"START_TIME" TIMESTAMP (6), 
	"END_TIME" TIMESTAMP (6), 
	"COMPANY_ID" NUMBER(*,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;