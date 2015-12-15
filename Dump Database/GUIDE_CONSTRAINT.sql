--------------------------------------------------------
--  Constraints for Table GUIDE
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."GUIDE" ADD CONSTRAINT "GUIDE_PK" PRIMARY KEY ("PASSPORT_NO")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("COMPANY_ID" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("STATUS" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("TEL" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("ADDRESS" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("PASSPORT_NO" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."GUIDE" MODIFY ("NAME" NOT NULL ENABLE);
